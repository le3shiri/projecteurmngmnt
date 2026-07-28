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

        // 4. Calculate total & remaining
        $total = 0;
        foreach ($request->items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        $advanceCash = $request->input('advance_cash', 0) ?: 0;
        $advanceTransfer = $request->input('advance_transfer', 0) ?: 0;
        $remaining = $total - ($advanceCash + $advanceTransfer);

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
        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
            $itemCommission = $itemData['quantity'] * ($product->commission_agent ?? 0);
            $totalCommission += $itemCommission;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_code' => $product->code,
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'prix_fournisseur' => $product->prix_fournisseur ?? 0,
                'commission_agent' => $product->commission_agent ?? 0,
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
        
        $data = [
            'order' => $order,
            'title' => strtoupper($type) . ' - ' . $order->code,
            'type' => $type
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

        if ($request->amount > $order->remaining) {
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

        // Update order
        if ($request->type === 'cash') {
            $order->increment('advance_cash', $request->amount);
        } else {
            $order->increment('advance_transfer', $request->amount);
        }
        $order->decrement('remaining', $request->amount);

        // Auto mark as confirmed if remaining is 0 or status is pending
        if ($order->remaining <= 0 && $order->status === 'pending') {
            $order->status = 'confirmed';
            $order->save();

            if (!$order->supplierOrder) {
                SupplierOrder::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);
            }
        }

        return back()->with('success', 'Paiement enregistré avec succès.');
    }
}
