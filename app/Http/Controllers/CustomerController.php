<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sort = $request->input('sort', 'latest');

        $perPage = (int) $request->input('per_page', 15);
        if ($perPage < 1) {
            $perPage = 15;
        } elseif ($perPage > 200) {
            $perPage = 200;
        }

        $query = Customer::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $sort = 'latest';
                $query->orderBy('created_at', 'desc');
                break;
        }

        $customers = $query->paginate($perPage)->withQueryString();

        return view('customers.index', compact('customers', 'search', 'startDate', 'endDate', 'sort', 'perPage'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'company' => $request->company,
            'address' => $request->address,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('customers.index')->with('success', 'Client créé avec succès.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function show(Customer $customer)
    {
        $customer->load('orders.agent');
        return view('customers.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Seul un administrateur peut supprimer un client.');
        }

        \DB::transaction(function () use ($customer) {
            foreach ($customer->orders as $order) {
                if ($order->logo_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($order->logo_path);
                }

                $order->items()->delete();
                $order->payments()->delete();
                if ($order->commission) {
                    $order->commission()->delete();
                }
                if ($order->supplierOrder) {
                    $order->supplierOrder()->delete();
                }
                $order->delete();
            }

            $customer->delete();
        });

        return redirect()->route('customers.index')->with('success', 'Client et son historique ont été supprimés avec succès.');
    }
}
