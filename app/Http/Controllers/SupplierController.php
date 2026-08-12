<?php

namespace App\Http\Controllers;

use App\Models\SupplierOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Delete any supplier order records for pending or cancelled orders
        SupplierOrder::whereIn('order_id', Order::whereIn('status', ['pending', 'cancelled'])->pluck('id'))->delete();

        // Auto-synchronize confirmed, shipped, or delivered orders
        $confirmedOrderIds = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])->pluck('id');
        foreach ($confirmedOrderIds as $orderId) {
            SupplierOrder::firstOrCreate(
                ['order_id' => $orderId],
                ['status' => 'pending', 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query ensuring order is active & confirmed
        $baseQuery = SupplierOrder::whereHas('order', function ($q) {
            $q->whereIn('status', ['confirmed', 'shipped', 'delivered']);
        });

        $query = (clone $baseQuery)->with(['order.customer', 'order.items', 'order.agent']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Stats counts
        $counts = [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'preparing' => (clone $baseQuery)->where('status', 'preparing')->count(),
            'shipped' => (clone $baseQuery)->where('status', 'shipped')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
        ];

        $supplierOrders = $query->latest()->paginate(15);
        return view('supplier.index', compact('supplierOrders', 'status', 'startDate', 'endDate', 'counts'));
    }

    public function updateStatus(Request $request, SupplierOrder $supplierOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,shipped,completed',
            'notes' => 'nullable|string',
        ]);

        $status = $request->status;
        
        $updateData = [
            'status' => $status,
            'notes' => $request->notes,
            'supplier_id' => auth()->id(),
        ];

        if ($status === 'shipped') {
            $updateData['shipped_at'] = now();
            // Automatically update core order status to shipped
            $supplierOrder->order->update(['status' => 'shipped']);
        } elseif ($status === 'completed') {
            $updateData['completed_at'] = now();
            // Automatically update core order status to delivered
            $supplierOrder->order->update(['status' => 'delivered']);
        }

        $supplierOrder->update($updateData);

        return back()->with('success', 'Statut de préparation fournisseur mis à jour.');
    }
}
