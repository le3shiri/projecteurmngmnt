<?php

namespace App\Http\Controllers;

use App\Models\CustomerDiscountLink;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerCatalogController extends Controller
{
    /**
     * Display the exclusive customer catalogue page with active discounts.
     */
    public function show($token)
    {
        $link = CustomerDiscountLink::where('token', $token)->with('customer')->firstOrFail();
        $customer = $link->customer;

        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        $categories = Category::all();
        $discountRate = $link->getCurrentDiscountRate();
        $isInitialPeriod = $link->isInitialPeriodActive();
        $remainingSeconds = $link->getRemainingSeconds();
        $remainingDays = $link->getRemainingDays();
        $initialExpiresAt = $link->initial_expires_at;

        $pastLogoPath = $customer->getPastLogoPath();
        $pastLogoUrl = $customer->past_logo_url;

        return view('catalog.special', compact(
            'link',
            'customer',
            'products',
            'categories',
            'discountRate',
            'isInitialPeriod',
            'remainingSeconds',
            'remainingDays',
            'initialExpiresAt',
            'pastLogoPath',
            'pastLogoUrl'
        ));
    }

    /**
     * Handle order submission directly from the customer.
     */
    public function placeOrder(Request $request, $token)
    {
        $link = CustomerDiscountLink::where('token', $token)->with(['customer', 'admin'])->firstOrFail();
        $customer = $link->customer;

        $request->validate([
            'items' => 'nullable|array',
            'units' => 'nullable|array',
            'global_notes' => 'nullable|string|max:1000',
            'global_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:10240',
            'phone' => 'nullable|string|max:50',
            'delivery_address' => 'nullable|string|max:500',
        ]);

        if (empty($request->units) && empty($request->items)) {
            return back()->with('error', 'Veuillez ajouter au moins un projecteur à votre commande.');
        }

        $discountRate = $link->getCurrentDiscountRate();
        $discountFactor = (100 - $discountRate) / 100;

        // Admin who will own the order & commission
        $adminId = $link->admin_id ?? User::where('role', 'admin')->first()?->id;

        // Past logo from database
        $pastLogoPath = $customer->getPastLogoPath();

        // Upload global logo if provided
        $globalLogoPath = null;
        if ($request->hasFile('global_logo')) {
            $globalLogoPath = $request->file('global_logo')->store('logos', 'public');
        }

        // Update customer contact info if updated
        if ($request->filled('phone')) {
            $customer->update(['phone' => $request->phone]);
        }
        if ($request->filled('delivery_address')) {
            $customer->update(['address' => $request->delivery_address]);
        }

        // Calculate totals
        $originalTotal = 0;
        $discountedTotal = 0;
        $totalCommission = 0;

        $hasUnits = $request->has('units') && is_array($request->units) && count($request->units) > 0;

        // Resolve first unit logo
        $firstUnitLogo = null;
        if ($hasUnits) {
            $firstSource = $request->input('units.0.logo_source', 'past_logo');
            if ($request->hasFile('units.0.logo_file')) {
                $firstUnitLogo = $request->file('units.0.logo_file')->store('logos', 'public');
            } elseif ($firstSource === 'past_logo' && $pastLogoPath) {
                $firstUnitLogo = $pastLogoPath;
            } elseif ($globalLogoPath) {
                $firstUnitLogo = $globalLogoPath;
            } elseif ($pastLogoPath) {
                $firstUnitLogo = $pastLogoPath;
            }

            foreach ($request->units as $unitData) {
                $product = Product::find($unitData['product_id']);
                if (!$product) continue;
                $origPrice = (float) $product->price;
                $discPrice = round($origPrice * $discountFactor, 2);

                $originalTotal += $origPrice;
                $discountedTotal += $discPrice;

                $commRate = $product->getCommissionForAgent($adminId);
                $totalCommission += $commRate;
            }
        } else {
            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                if (!$product) continue;
                $qty = (int) $itemData['quantity'];
                $origPrice = (float) $product->price;
                $discPrice = round($origPrice * $discountFactor, 2);

                $originalTotal += ($qty * $origPrice);
                $discountedTotal += ($qty * $discPrice);

                $commRate = $product->getCommissionForAgent($adminId);
                $totalCommission += ($qty * $commRate);
            }
        }

        $code = 'CMD-VIP-' . strtoupper(Str::random(6));
        $discountAmount = max(0, round($originalTotal - $discountedTotal, 2));

        // Create the Order assigned to the Admin with VIP source
        $order = Order::create([
            'code' => $code,
            'customer_id' => $customer->id,
            'agent_id' => $adminId,
            'status' => 'pending',
            'total' => $discountedTotal,
            'advance_cash' => 0,
            'advance_transfer' => 0,
            'remaining' => $discountedTotal,
            'logo_path' => $firstUnitLogo ?: $globalLogoPath ?: $pastLogoPath,
            'notes' => $request->global_notes,
            'source' => 'customer_vip',
            'discount_rate' => $discountRate,
            'discount_amount' => $discountAmount,
            'customer_discount_link_id' => $link->id,
        ]);

        // Create Order Items & deduct stock
        if ($hasUnits) {
            foreach ($request->units as $index => $unitData) {
                $product = Product::find($unitData['product_id']);
                if (!$product) continue;
                $discPrice = round((float)$product->price * $discountFactor, 2);

                $source = $unitData['logo_source'] ?? ($index === 0 ? 'past_logo' : 'same_as_first');
                $itemLogoPath = null;

                if ($index === 0) {
                    $itemLogoPath = $firstUnitLogo;
                } else {
                    if ($source === 'same_as_first') {
                        $itemLogoPath = $firstUnitLogo;
                    } elseif ($source === 'past_logo') {
                        $itemLogoPath = $pastLogoPath ?: $firstUnitLogo;
                    } elseif ($source === 'new_upload' && $request->hasFile("units.{$index}.logo_file")) {
                        $itemLogoPath = $request->file("units.{$index}.logo_file")->store('logos', 'public');
                    } else {
                        $itemLogoPath = $firstUnitLogo ?: $pastLogoPath;
                    }
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'quantity' => 1,
                    'unit_price' => $discPrice,
                    'prix_fournisseur' => $product->prix_fournisseur ?? 0,
                    'commission_agent' => $product->getCommissionForAgent($adminId),
                    'total' => $discPrice,
                    'description' => $unitData['notes'] ?? null,
                    'logo_path' => $itemLogoPath,
                ]);

                $product->decrement('stock', 1);
            }
        } else {
            foreach ($request->items as $index => $itemData) {
                $product = Product::find($itemData['product_id']);
                if (!$product) continue;
                $qty = (int) $itemData['quantity'];
                $discPrice = round((float)$product->price * $discountFactor, 2);
                $itemTotal = round($qty * $discPrice, 2);

                $itemLogoPath = null;
                if ($request->hasFile("items.{$index}.logo")) {
                    $itemLogoPath = $request->file("items.{$index}.logo")->store('logos', 'public');
                } elseif ($globalLogoPath) {
                    $itemLogoPath = $globalLogoPath;
                } elseif ($pastLogoPath) {
                    $itemLogoPath = $pastLogoPath;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'quantity' => $qty,
                    'unit_price' => $discPrice,
                    'prix_fournisseur' => $product->prix_fournisseur ?? 0,
                    'commission_agent' => $product->getCommissionForAgent($adminId),
                    'total' => $itemTotal,
                    'description' => $itemData['notes'] ?? null,
                    'logo_path' => $itemLogoPath,
                ]);

                $product->decrement('stock', $qty);
            }
        }

        // Commission attributed to admin
        if ($adminId && $totalCommission > 0) {
            Commission::create([
                'agent_id' => $adminId,
                'order_id' => $order->id,
                'rate' => 0.00,
                'amount' => $totalCommission,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('catalog.special.confirmation', [
            'token' => $token,
            'order_code' => $order->code,
        ]);
    }

    /**
     * Confirmation screen after order placement.
     */
    public function confirmation($token, Request $request)
    {
        $link = CustomerDiscountLink::where('token', $token)->with('customer')->firstOrFail();
        $customer = $link->customer;
        $orderCode = $request->query('order_code');
        $order = Order::where('code', $orderCode)->with('items')->first();

        return view('catalog.confirmation', compact('link', 'customer', 'order'));
    }
}

