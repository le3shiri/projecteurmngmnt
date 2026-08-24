<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\SupplierOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->input('status');
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($user->isSupplier()) {
            return redirect()->route('supplier.index');
        }

        // Security check: Agents see only their orders.
        $query = Order::with(['customer', 'agent']);
        
        if ($user->isAgent()) {
            $query->where('agent_id', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $orders = $query->latest()->paginate(15);

        return view('orders.index', compact('orders', 'status', 'search', 'startDate', 'endDate'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:existing,new',
            // if existing
            'customer_id' => 'required_if:customer_type,existing|nullable|exists:customers,id',
            // if new
            'customer_name' => 'required_if:customer_type,new|nullable|string|max:255',
            'customer_phone' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'customer_address' => 'nullable|string',
            
            // Order details
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            
            'advance_cash' => 'nullable|numeric|min:0',
            'advance_transfer' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'notes' => 'nullable|string',
            'delivery_date' => 'nullable|date',
            'status' => 'required|in:pending,confirmed',
        ]);

        // 1. Get or Create Customer
        if ($request->customer_type === 'new') {
            $customer = Customer::create([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'address' => $request->customer_address,
                'created_by' => auth()->id(),
            ]);
            $customerId = $customer->id;
        } else {
            $customerId = $request->customer_id;
        }

        // 2. Upload Logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // 3. Create unique Order Code
        $code = 'CMD-' . strtoupper(Str::random(8));

        // 4. Calculate total & remaining (prices are HT, so remaining is TTC - advances)
        $total = 0; // Total HT
        foreach ($request->items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        $advanceCash = $request->input('advance_cash', 0) ?: 0;
        $advanceTransfer = $request->input('advance_transfer', 0) ?: 0;
        $totalTtc = $total;
        $remaining = max(0, $totalTtc - ($advanceCash + $advanceTransfer));

        $order = Order::create([
            'code' => $code,
            'customer_id' => $customerId,
            'agent_id' => auth()->id(),
            'status' => $request->status,
            'total' => $total,
            'advance_cash' => $advanceCash,
            'advance_transfer' => $advanceTransfer,
            'remaining' => $remaining,
            'logo_path' => $logoPath,
            'notes' => $request->notes,
            'delivery_date' => $request->delivery_date,
        ]);

        // 5. Create items & deduct stock
        $totalCommission = 0;
        $agentId = auth()->id();
        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
            $agentCommissionRate = $product->getCommissionForAgent($agentId);
            $itemCommission = $itemData['quantity'] * $agentCommissionRate;
            $totalCommission += $itemCommission;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_code' => $product->code,
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'prix_fournisseur' => $product->prix_fournisseur ?? 0,
                'commission_agent' => $agentCommissionRate,
                'total' => $itemTotal,
            ]);

            // Deduct stock
            $product->decrement('stock', $itemData['quantity']);
        }

        // 6. Calculate commission if agent created order
        $agent = auth()->user();
        if ($agent->isAgent()) {
            Commission::create([
                'agent_id' => $agent->id,
                'order_id' => $order->id,
                'rate' => 0.00,
                'amount' => $totalCommission,
                'status' => 'pending',
            ]);
        }

        // 7. Auto trigger supplier order if status is confirmed
        if ($request->status === 'confirmed') {
            SupplierOrder::create([
                'order_id' => $order->id,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Commande enregistrée avec succès.');
    }

    public function show(Order $order)
    {
        $user = auth()->user();
        // Agent check
        if ($user->isAgent() && $order->agent_id !== $user->id) {
            abort(403, 'Vous ne pouvez pas accéder à cette commande.');
        }

        $order->load(['customer', 'agent', 'items', 'supplierOrder']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,shipped,delivered',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        // If changed to confirmed, add to supplier workflow
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            if (!$order->supplierOrder) {
                SupplierOrder::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);
            }
        }

        // Return stock if cancelled
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }
        }

        $order->save();
        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    // Document generation PDF
    public function downloadPdf(Order $order, $type)
    {
        $user = auth()->user();
        if ($user->isAgent() && $order->agent_id !== $user->id) {
            abort(403);
        }

        $order->load(['customer', 'agent', 'items']);

        // Load company logo as base64
        $logoPath = public_path('logo.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Arabic text shaper
        require_once base_path('vendor/khaled.alshamaa/ar-php/src/Arabic.php');
        $arabic = new \ArPHP\I18N\Arabic();

        $formatText = function ($text) use ($arabic) {
            if (empty($text)) return '';
            if (preg_match('/\p{Arabic}/u', $text)) {
                return $arabic->utf8Glyphs($text);
            }
            return $text;
        };

        // Format customer fields for Arabic support
        $customerNameFormatted = $formatText($order->customer->name ?? '');
        $customerCompanyFormatted = $formatText($order->customer->company ?? '');
        $customerAddressFormatted = $formatText($order->customer->address ?? '');

        // Format item product names for Arabic support if needed
        foreach ($order->items as $item) {
            $item->formatted_name = $formatText($item->product_name ?? '');
        }

        // Calculate Totals (0% TVA default):
        $totalHt = (float) $order->total;
        $tva = 0.00;
        $totalTtc = $totalHt;
        $advances = (float) ($order->advance_cash + $order->advance_transfer);
        $remaining = max(0, $totalTtc - $advances);

        // Spellout Total TTC in French words
        $totalInWords = '';
        try {
            if (class_exists('NumberFormatter')) {
                $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
                $totalInWords = mb_strtoupper($formatter->format((int) round($totalTtc)));
            }
        } catch (\Exception $e) {
            $totalInWords = '';
        }

        $data = [
            'order' => $order,
            'title' => strtoupper($type) . ' - ' . $order->code,
            'type' => $type,
            'logoBase64' => $logoBase64,
            'customerNameFormatted' => $customerNameFormatted,
            'customerCompanyFormatted' => $customerCompanyFormatted,
            'customerAddressFormatted' => $customerAddressFormatted,
            'totalHt' => $totalHt,
            'tva' => $tva,
            'tvaRate' => 0,
            'totalTtc' => $totalTtc,
            'advances' => $advances,
            'remaining' => $remaining,
            'totalInWords' => $totalInWords,
        ];

        // Renders view from views/orders/pdf.blade.php
        $pdf = Pdf::loadView('orders.pdf', $data);

        return $pdf->download($type . '_' . $order->code . '.pdf');
    }

    public function addPayment(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:cash,transfer,cheque',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Compute true remaining: total price - all advances (no TVA)
        $currentRemaining = max(0, (float)$order->total - (float)($order->advance_cash + $order->advance_transfer));

        if ($request->amount > $currentRemaining) {
            return back()->with('error', 'Le montant saisi dépasse le solde restant.');
        }

        // Record payment
        $order->payments()->create([
            'amount' => $request->amount,
            'type' => $request->type,
            'reference' => $request->reference,
            'notes' => $request->notes,
            'payment_date' => now(),
            'recorded_by' => auth()->id(),
        ]);

        // Update order advances
        if ($request->type === 'cash') {
            $order->increment('advance_cash', $request->amount);
        } else {
            $order->increment('advance_transfer', $request->amount);
        }

        // Recalculate and save the correct remaining (total - all advances, no TVA)
        $order->refresh();
        $newRemaining = max(0, (float)$order->total - (float)($order->advance_cash + $order->advance_transfer));
        $order->remaining = $newRemaining;

        // Auto mark as confirmed if fully paid
        if ($newRemaining <= 0 && $order->status === 'pending') {
            $order->status = 'confirmed';

            if (!$order->supplierOrder) {
                SupplierOrder::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);
            }
        }
        $order->save();

        return back()->with('success', 'Paiement enregistré avec succès.');
    }

    public function destroy(Order $order)
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Seul un administrateur peut supprimer une commande.');
        }

        \DB::transaction(function () use ($order) {
            // Restore product stock if order was not cancelled
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product_id) {
                        $product = Product::find($item->product_id);
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            }

            // Delete custom logo file if exists
            if ($order->logo_path) {
                Storage::disk('public')->delete($order->logo_path);
            }

            // Delete related records
            $order->items()->delete();
            $order->payments()->delete();
            if ($order->commission) {
                $order->commission()->delete();
            }
            if ($order->supplierOrder) {
                $order->supplierOrder()->delete();
            }

            $order->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Commande supprimée avec succès.');
    }

    // Document Editor View
    public function editDocument(Order $order, $type)
    {
        $user = auth()->user();
        if ($user->isAgent() && $order->agent_id !== $user->id) {
            abort(403);
        }

        $order->load(['customer', 'agent', 'items']);

        return view('orders.document_editor', compact('order', 'type'));
    }

    // Process Custom Document Generation & Download
    public function generateCustomDocumentPdf(Request $request, Order $order, $type)
    {
        $user = auth()->user();
        if ($user->isAgent() && $order->agent_id !== $user->id) {
            abort(403);
        }

        // Load company logo as base64
        $logoPath = public_path('logo.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Arabic shaper
        require_once base_path('vendor/khaled.alshamaa/ar-php/src/Arabic.php');
        $arabic = new \ArPHP\I18N\Arabic();

        $formatText = function ($text) use ($arabic) {
            if (empty($text)) return '';
            if (preg_match('/\p{Arabic}/u', $text)) {
                return $arabic->utf8Glyphs($text);
            }
            return $text;
        };

        $customerNameFormatted = $formatText($request->input('customer_name', $order->customer->name ?? ''));
        $customerCompanyFormatted = $formatText($request->input('customer_company', $order->customer->company ?? ''));
        $customerAddressFormatted = $formatText($request->input('customer_address', $order->customer->address ?? ''));

        // Custom items array from form input
        $items = [];
        $totalHt = 0;
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $itemData) {
                $qty = (int) ($itemData['quantity'] ?? 1);
                $unitPrice = (float) ($itemData['unit_price'] ?? 0);
                $rowTotal = $qty * $unitPrice;
                $totalHt += $rowTotal;

                $items[] = (object) [
                    'product_code' => $itemData['code'] ?? '',
                    'product_name' => $itemData['name'] ?? '',
                    'formatted_name' => $formatText($itemData['name'] ?? ''),
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'total' => $rowTotal,
                ];
            }
        } else {
            foreach ($order->items as $item) {
                $rowTotal = $item->quantity * $item->unit_price;
                $totalHt += $rowTotal;
                $item->formatted_name = $formatText($item->product_name ?? '');
                $items[] = $item;
            }
        }

        $tvaRate = (float) $request->input('tva_rate', 0);
        $tva = $totalHt * ($tvaRate / 100);
        $totalTtc = $totalHt + $tva;
        $advances = (float) $request->input('advances', ($order->advance_cash + $order->advance_transfer));
        $remaining = max(0, $totalTtc - $advances);

        // Spellout Total TTC
        $totalInWords = '';
        try {
            if (class_exists('NumberFormatter')) {
                $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
                $totalInWords = mb_strtoupper($formatter->format((int) round($totalTtc)));
            }
        } catch (\Exception $e) {
            $totalInWords = '';
        }

        // Custom order override object
        $customOrder = (object) [
            'code' => $request->input('doc_number', $order->code),
            'created_at' => \Carbon\Carbon::parse($request->input('doc_date', $order->created_at->format('Y-m-d'))),
            'customer' => (object) [
                'name' => $request->input('customer_name', $order->customer->name ?? ''),
                'company' => $request->input('customer_company', $order->customer->company ?? ''),
                'phone' => $request->input('customer_phone', $order->customer->phone ?? ''),
                'email' => $request->input('customer_email', $order->customer->email ?? ''),
                'address' => $request->input('customer_address', $order->customer->address ?? ''),
            ],
            'items' => $items,
        ];

        $data = [
            'order' => $customOrder,
            'title' => strtoupper($type) . ' - ' . $customOrder->code,
            'type' => $type,
            'logoBase64' => $logoBase64,
            'customerNameFormatted' => $customerNameFormatted,
            'customerCompanyFormatted' => $customerCompanyFormatted,
            'customerAddressFormatted' => $customerAddressFormatted,
            'totalHt' => $totalHt,
            'tva' => $tva,
            'tvaRate' => $tvaRate,
            'totalTtc' => $totalTtc,
            'advances' => $advances,
            'remaining' => $remaining,
            'totalInWords' => $totalInWords,
            'emitterName' => $request->input('emitter_name', 'Projecteur CRM Inc.'),
            'emitterSubtitle' => $request->input('emitter_subtitle', 'Boutique physique et en ligne'),
            'emitterCountry' => $request->input('emitter_country', 'Maroc'),
            'emitterPhone' => $request->input('emitter_phone', '+212 600-000000'),
            'emitterEmail' => $request->input('emitter_email', 'contact@projecteurlogo.com'),
        ];

        $pdf = Pdf::loadView('orders.pdf', $data);

        return $pdf->download($type . '_' . $customOrder->code . '.pdf');
    }

    // ─── Shipping Ticket Upload ───────────────────────────────────────────────
    public function uploadShippingTicket(Request $request, Order $order)
    {
        $user = auth()->user();
        // Both admins and agents with the right permissions can upload
        if (!$user->isAdmin()
            && !$user->hasPermission('manage_orders')
            && !$user->hasPermission('update_order_status')
            && !$user->hasPermission('upload_shipping_ticket')) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'shipping_ticket' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:5120',
        ]);

        // Delete old ticket if exists
        if ($order->shipping_ticket_path) {
            Storage::disk('public')->delete($order->shipping_ticket_path);
        }

        $path = $request->file('shipping_ticket')->store('shipping_tickets', 'public');
        $order->shipping_ticket_path = $path;
        $order->save();

        return back()->with('success', 'Ticket d\'expédition joint avec succès.');
    }

    // ─── Edit Order Form ──────────────────────────────────────────────────────
    public function edit(Order $order)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasPermission('manage_orders')) {
            abort(403, 'Action non autorisée.');
        }

        $order->load(['customer', 'agent', 'items', 'supplierOrder']);
        $customers = Customer::orderBy('name')->get();
        $products  = Product::where('is_active', true)->get();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    // ─── Update Order ─────────────────────────────────────────────────────────
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->hasPermission('manage_orders')) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'customer_id'              => 'required|exists:customers,id',
            'items'                    => 'required|array|min:1',
            'items.*.product_id'       => 'required|exists:products,id',
            'items.*.quantity'         => 'required|integer|min:1',
            'items.*.unit_price'       => 'required|numeric|min:0',
            'advance_cash'             => 'nullable|numeric|min:0',
            'advance_transfer'         => 'nullable|numeric|min:0',
            'logo'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'notes'                    => 'nullable|string',
            'delivery_date'            => 'nullable|date',
            'status'                   => 'required|in:pending,confirmed,cancelled,shipped,delivered',
        ]);

        // 1. Logo update
        if ($request->hasFile('logo')) {
            if ($order->logo_path) {
                Storage::disk('public')->delete($order->logo_path);
            }
            $order->logo_path = $request->file('logo')->store('logos', 'public');
        }

        // 2. Restore stock for existing items before recreating them
        foreach ($order->items as $oldItem) {
            if ($oldItem->product_id && $order->status !== 'cancelled') {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('stock', $oldItem->quantity);
                }
            }
        }
        $order->items()->delete();

        // 3. Recalculate total & recreate items
        $total = 0;
        $agentId = $order->agent_id ?? auth()->id();
        $totalCommission = 0;
        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            $qty     = (int) $itemData['quantity'];
            $price   = (float) $itemData['unit_price'];
            $itemTotal = $qty * $price;
            $total += $itemTotal;

            $agentCommissionRate = $product->getCommissionForAgent($agentId);
            $totalCommission += $qty * $agentCommissionRate;

            OrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $product->id,
                'product_name'      => $product->name,
                'product_code'      => $product->code,
                'quantity'          => $qty,
                'unit_price'        => $price,
                'prix_fournisseur'  => $product->prix_fournisseur ?? 0,
                'commission_agent'  => $agentCommissionRate,
                'total'             => $itemTotal,
            ]);

            // Deduct stock for new quantities
            if ($request->status !== 'cancelled') {
                $product->decrement('stock', $qty);
            }
        }

        $advanceCash     = $request->input('advance_cash', 0) ?: 0;
        $advanceTransfer = $request->input('advance_transfer', 0) ?: 0;
        $remaining       = max(0, $total - ($advanceCash + $advanceTransfer));

        // 4. Handle status transition → supplier order
        $oldStatus = $order->status;
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            if (!$order->supplierOrder) {
                SupplierOrder::create(['order_id' => $order->id, 'status' => 'pending']);
            }
        }

        // 5. Update order record
        $order->update([
            'customer_id'     => $request->customer_id,
            'status'          => $request->status,
            'total'           => $total,
            'advance_cash'    => $advanceCash,
            'advance_transfer'=> $advanceTransfer,
            'remaining'       => $remaining,
            'notes'           => $request->notes,
            'delivery_date'   => $request->delivery_date,
        ]);

        // 6. Update agent commission if applicable
        if ($order->commission) {
            $order->commission()->update(['amount' => $totalCommission]);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Commande mise à jour avec succès.');
    }
}
