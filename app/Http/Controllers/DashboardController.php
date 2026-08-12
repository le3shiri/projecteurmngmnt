<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Commission;
use App\Models\Expense;
use App\Models\Product;
use App\Models\ProspectFile;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($user->isAdmin()) {
            return $this->adminDashboard($startDate, $endDate);
        } elseif ($user->isSupplier()) {
            return redirect()->route('supplier.index');
        } else {
            return $this->agentDashboard($startDate, $endDate);
        }
    }

    private function adminDashboard($startDate = null, $endDate = null)
    {
        $ordersQuery = Order::with('items')->where('status', '!=', 'cancelled');
        $commissionsQuery = Commission::query();
        $expensesQuery = Expense::query();

        if ($startDate) {
            $ordersQuery->whereDate('created_at', '>=', $startDate);
            $commissionsQuery->whereDate('created_at', '>=', $startDate);
            $expensesQuery->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $ordersQuery->whereDate('created_at', '<=', $endDate);
            $commissionsQuery->whereDate('created_at', '<=', $endDate);
            $expensesQuery->whereDate('date', '<=', $endDate);
        }

        $ordersAll = $ordersQuery->get();

        $montantEnCaisse = $ordersAll->sum(function ($order) {
            return $order->advance_cash + $order->advance_transfer;
        });

        $totalPrixFournisseur = $ordersAll->sum(function ($order) {
            return $order->items->sum(function ($item) {
                return $item->quantity * $item->prix_fournisseur;
            });
        });

        $totalSales = $montantEnCaisse - $totalPrixFournisseur;
        $remainingPayments = $ordersAll->sum('remaining');
        
        $commissionsPendingQuery = clone $commissionsQuery;
        $commissionsPaidQuery = clone $commissionsQuery;

        $commissionsPending = $commissionsPendingQuery->where('status', 'pending')->sum('amount');
        $commissionsPaid = $commissionsPaidQuery->where('status', 'paid')->sum('amount');
        
        $totalExpenses = $expensesQuery->sum('amount');
        $netProfit = $totalSales - $totalExpenses - ($commissionsPending + $commissionsPaid);

        // Low stock alert
        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        // Recent Orders
        $recentOrdersQuery = Order::with(['customer', 'agent']);
        if ($startDate) {
            $recentOrdersQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $recentOrdersQuery->whereDate('created_at', '<=', $endDate);
        }
        $recentOrders = $recentOrdersQuery->latest()->take(5)->get();

        // Prospect Progress Overview
        $prospectFilesQuery = ProspectFile::with('agent');
        if ($startDate) {
            $prospectFilesQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $prospectFilesQuery->whereDate('created_at', '<=', $endDate);
        }
        $prospectFiles = $prospectFilesQuery->latest()->take(5)->get();

        // Monthly stats for chart (current year or date range filtered)
        $chartLabels = [];
        $chartData = [];
        $months = ['Jan', 'Féb', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

        if ($startDate || $endDate) {
            $chartOrders = $ordersAll;
        } else {
            $chartOrders = Order::with('items')
                ->where('status', '!=', 'cancelled')
                ->whereYear('created_at', date('Y'))
                ->get();
        }

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i - 1];
            $monthOrders = $chartOrders->filter(function ($order) use ($i) {
                return $order->created_at->month == $i;
            });
            $caisse = $monthOrders->sum(function ($order) {
                return $order->advance_cash + $order->advance_transfer;
            });
            $fournisseur = $monthOrders->sum(function ($order) {
                return $order->items->sum(function ($item) {
                    return $item->quantity * $item->prix_fournisseur;
                });
            });
            $chartData[] = floatval($caisse - $fournisseur);
        }

        return view('dashboard.admin', compact(
            'totalSales', 'remainingPayments', 'commissionsPending', 'commissionsPaid', 
            'totalExpenses', 'netProfit', 'lowStockProducts', 'recentOrders', 
            'prospectFiles', 'chartLabels', 'chartData', 'startDate', 'endDate'
        ));
    }

    private function supplierDashboard()
    {
        // Supplier sees orders waiting for preparation/shipping
        $pendingPreparation = Order::where('status', 'confirmed')
            ->whereDoesntHave('supplierOrder')
            ->orWhereHas('supplierOrder', function ($q) {
                $q->where('status', 'pending');
            })->count();

        $preparingCount = Order::whereHas('supplierOrder', function ($q) {
            $q->where('status', 'preparing');
        })->count();

        $shippedCount = Order::whereHas('supplierOrder', function ($q) {
            $q->where('status', 'shipped');
        })->count();

        $recentSupplierOrders = Order::with(['customer', 'supplierOrder'])
            ->whereIn('status', ['confirmed', 'shipped'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.supplier', compact(
            'pendingPreparation', 'preparingCount', 'shippedCount', 'recentSupplierOrders'
        ));
    }

    private function agentDashboard($startDate = null, $endDate = null)
    {
        $user = auth()->user();

        // Agent stats queries
        $salesQuery = Order::where('agent_id', $user->id)->where('status', '!=', 'cancelled');
        $commissionsQuery = Commission::where('agent_id', $user->id);

        if ($startDate) {
            $salesQuery->whereDate('created_at', '>=', $startDate);
            $commissionsQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $salesQuery->whereDate('created_at', '<=', $endDate);
            $commissionsQuery->whereDate('created_at', '<=', $endDate);
        }

        $mySalesTotal = $salesQuery->sum('total');

        $commissionsPendingQuery = clone $commissionsQuery;
        $commissionsPaidQuery = clone $commissionsQuery;

        $myPendingCommissions = $commissionsPendingQuery->where('status', 'pending')->sum('amount');
        $myPaidCommissions = $commissionsPaidQuery->where('status', 'paid')->sum('amount');

        // Recent personal orders
        $myRecentOrdersQuery = Order::with('customer')->where('agent_id', $user->id);
        if ($startDate) {
            $myRecentOrdersQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $myRecentOrdersQuery->whereDate('created_at', '<=', $endDate);
        }
        $myRecentOrders = $myRecentOrdersQuery->latest()->take(5)->get();

        // Prospect Lists assigned to agent
        $myProspectFilesQuery = ProspectFile::where('agent_id', $user->id);
        if ($startDate) {
            $myProspectFilesQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $myProspectFilesQuery->whereDate('created_at', '<=', $endDate);
        }
        $myProspectFiles = $myProspectFilesQuery->latest()->take(5)->get();

        // Count pending calls
        $pendingCallsCount = Prospect::whereHas('file', function ($q) use ($user) {
            $q->where('agent_id', $user->id);
        })->where('status', 'pending')->count();

        return view('dashboard.agent', compact(
            'mySalesTotal', 'myPendingCommissions', 'myPaidCommissions', 
            'myRecentOrders', 'myProspectFiles', 'pendingCallsCount', 'startDate', 'endDate'
        ));
    }
}
