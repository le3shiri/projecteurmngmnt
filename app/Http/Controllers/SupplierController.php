<?php

namespace App\Http\Controllers;

use App\Models\SupplierOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = SupplierOrder::with(['order.customer', 'order.items']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $supplierOrders = $query->latest()->paginate(15);
        return view('supplier.index', compact('supplierOrders', 'status', 'startDate', 'endDate'));
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
