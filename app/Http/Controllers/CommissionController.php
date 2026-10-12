<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $selectedAgentId = $request->input('agent_id');

        // Auto-reconcile any missing commission records from confirmed/existing orders
        $this->reconcileMissingCommissions();

        if ($user->isAdmin() || $user->hasPermission('manage_users') || $user->hasPermission('view_commissions')) {
            // Admin or Manager view
            $agentsQuery = User::whereIn('role', ['agent', 'media_buyer'])->orderBy('name');
            if ($selectedAgentId) {
                $agentsQuery->where('id', $selectedAgentId);
            }
            $agents = $agentsQuery->get();

            // Calculate aggregated statistics per agent
            $agentSummaries = [];
            foreach ($agents as $agent) {
                $cQuery = Commission::where('agent_id', $agent->id);
                if ($startDate) {
                    $cQuery->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $cQuery->whereDate('created_at', '<=', $endDate);
                }

                $totalEarned = (clone $cQuery)->sum('amount');
                $totalPaid = (clone $cQuery)->where('status', 'paid')->sum('amount');
                $totalPending = (clone $cQuery)->where('status', 'pending')->sum('amount');
                $pendingCount = (clone $cQuery)->where('status', 'pending')->count();

                $pendingCommissions = [];
                if ($pendingCount > 0) {
                    $pendingCommissions = (clone $cQuery)->where('status', 'pending')
                        ->with(['order.customer'])
                        ->latest()
                        ->get()
                        ->map(function ($comm) {
                            return [
                                'id' => $comm->id,
                                'amount' => (float) $comm->amount,
                                'order_id' => $comm->order_id,
                                'order_code' => $comm->order ? $comm->order->code : ('#COMM-' . $comm->id),
                                'order_status' => $comm->order ? $comm->order->status : 'pending',
                                'order_date' => $comm->order && $comm->order->created_at ? $comm->order->created_at->format('d/m/Y') : $comm->created_at->format('d/m/Y'),
                                'order_total' => $comm->order ? (float) $comm->order->total : 0,
                                'customer_name' => $comm->order && $comm->order->customer ? $comm->order->customer->name : '-',
                            ];
                        })->values()->all();
                }

                if ($totalEarned > 0 || $pendingCount > 0 || !$selectedAgentId) {
                    $agentSummaries[] = [
                        'agent' => $agent,
                        'total_earned' => $totalEarned,
                        'total_paid' => $totalPaid,
                        'total_pending' => $totalPending,
                        'pending_count' => $pendingCount,
                        'pending_commissions' => $pendingCommissions,
                    ];
                }
            }

            // Detailed commissions table
            $query = Commission::with(['agent', 'order.customer', 'order.items']);

            if ($selectedAgentId) {
                $query->where('agent_id', $selectedAgentId);
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $commissions = $query->latest()->paginate(20)->withQueryString();

            // Overall Totals
            $overallEarned = Commission::when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->sum('amount');
            $overallPaid = Commission::when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->where('status', 'paid')->sum('amount');
            $overallPending = Commission::when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                ->where('status', 'pending')->sum('amount');

            $allAgents = User::whereIn('role', ['agent', 'media_buyer'])->orderBy('name')->get();

            return view('commissions.index', compact(
                'agentSummaries',
                'commissions',
                'overallEarned',
                'overallPaid',
                'overallPending',
                'allAgents',
                'startDate',
                'endDate',
                'status',
                'selectedAgentId'
            ));

        } else {
            // Agent Personal View
            $query = Commission::where('agent_id', $user->id)->with(['order.customer', 'order.items']);

            if ($status) {
                $query->where('status', $status);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $myEarned = (clone $query)->sum('amount');
            $myPaid = (clone $query)->where('status', 'paid')->sum('amount');
            $myPending = (clone $query)->where('status', 'pending')->sum('amount');

            $commissions = $query->latest()->paginate(20)->withQueryString();

            return view('commissions.agent_index', compact(
                'commissions',
                'myEarned',
                'myPaid',
                'myPending',
                'startDate',
                'endDate',
                'status'
            ));
        }
    }

    public function showAgentCommissions(User $user, Request $request)
    {
        $currentUser = auth()->user();
        if (!$currentUser->isAdmin() && !$currentUser->hasPermission('manage_users') && $currentUser->id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = Commission::where('agent_id', $user->id)->with(['order.customer', 'order.items']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $totalEarned = (clone $query)->sum('amount');
        $totalPaid = (clone $query)->where('status', 'paid')->sum('amount');
        $totalPending = (clone $query)->where('status', 'pending')->sum('amount');

        $commissions = $query->latest()->paginate(20)->withQueryString();

        $pendingCommissions = Commission::where('agent_id', $user->id)
            ->where('status', 'pending')
            ->with(['order.customer'])
            ->latest()
            ->get()
            ->map(function ($comm) {
                return [
                    'id' => $comm->id,
                    'amount' => (float) $comm->amount,
                    'order_id' => $comm->order_id,
                    'order_code' => $comm->order ? $comm->order->code : ('#COMM-' . $comm->id),
                    'order_status' => $comm->order ? $comm->order->status : 'pending',
                    'order_date' => $comm->order && $comm->order->created_at ? $comm->order->created_at->format('d/m/Y') : $comm->created_at->format('d/m/Y'),
                    'order_total' => $comm->order ? (float) $comm->order->total : 0,
                    'customer_name' => $comm->order && $comm->order->customer ? $comm->order->customer->name : '-',
                ];
            })->values()->all();

        return view('commissions.show', compact(
            'user',
            'commissions',
            'pendingCommissions',
            'totalEarned',
            'totalPaid',
            'totalPending',
            'startDate',
            'endDate',
            'status'
        ));
    }

    public function markAsPaid(Request $request, Commission $commission)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
            'paid_at' => 'nullable|date',
        ]);

        $paidAt = $request->input('paid_at') ?: now();
        $notes = $request->input('notes') ?: 'Règlement effectué';

        $commission->update([
            'status' => 'paid',
            'paid_at' => $paidAt,
            'notes' => $notes,
        ]);

        $commission->load(['agent', 'order']);
        $orderCode = $commission->order->code ?? 'N/A';
        $agentName = $commission->agent->name ?? 'Agent';

        // Auto-add paid commission to Expenses
        \App\Models\Expense::create([
            'title' => "Commission Agent - {$agentName} ({$orderCode})",
            'category' => 'Commissions',
            'amount' => $commission->amount,
            'date' => $paidAt,
            'description' => "Règlement de commission pour la commande {$orderCode}. Notes: {$notes}",
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'La commission de ' . number_format($commission->amount, 2, ',', ' ') . ' DH a été marquée comme payée et enregistrée dans les dépenses.');
    }

    public function markAsPending(Request $request, Commission $commission)
    {
        $commission->load(['agent', 'order']);
        $orderCode = $commission->order->code ?? 'N/A';
        $agentName = $commission->agent->name ?? 'Agent';

        $commission->update([
            'status' => 'pending',
            'paid_at' => null,
            'notes' => 'Marquée comme non payée',
        ]);

        // Remove from Expenses if present
        \App\Models\Expense::where('category', 'Commissions')
            ->where('title', 'like', "%{$agentName}%")
            ->where('title', 'like', "%{$orderCode}%")
            ->delete();

        return back()->with('success', 'La commission a été remise en statut En attente et retirée des dépenses.');
    }

    public function payAllAgentPending(Request $request, User $user)
    {
        $currentUser = auth()->user();
        if (!$currentUser->isAdmin() && !$currentUser->hasPermission('manage_users')) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'commission_ids' => 'nullable|array',
            'commission_ids.*' => 'integer|exists:commissions,id',
            'notes' => 'nullable|string|max:500',
            'paid_at' => 'nullable|date',
        ]);

        $commissionIds = $request->input('commission_ids');

        $query = Commission::where('agent_id', $user->id)
            ->where('status', 'pending')
            ->with('order');

        if (!empty($commissionIds)) {
            $query->whereIn('id', $commissionIds);
        }

        $pendingCommissions = $query->get();

        if ($pendingCommissions->isEmpty()) {
            return back()->with('error', 'Aucune commission en attente de paiement sélectionnée pour cet agent.');
        }

        $totalPaidAmount = 0;
        $notes = $request->input('notes') ?: 'Règlement des commissions de l\'agent';
        $paidAt = $request->input('paid_at') ? \Carbon\Carbon::parse($request->input('paid_at')) : now();

        foreach ($pendingCommissions as $commission) {
            $totalPaidAmount += $commission->amount;
            $commission->update([
                'status' => 'paid',
                'paid_at' => $paidAt,
                'notes' => $notes,
            ]);

            $orderCode = $commission->order->code ?? ('#COMM-' . $commission->id);

            // Auto-add paid commission to Expenses
            \App\Models\Expense::create([
                'title' => "Commission Agent - {$user->name} ({$orderCode})",
                'category' => 'Commissions',
                'amount' => $commission->amount,
                'date' => $paidAt,
                'description' => "Règlement de commission pour la commande {$orderCode}. Notes: {$notes}",
                'created_by' => auth()->id(),
            ]);
        }

        $count = $pendingCommissions->count();
        return back()->with('success', "Paiement validé avec succès ! {$count} commande(s) réglée(s) pour {$user->name} (Total versé : " . number_format($totalPaidAmount, 2, ',', ' ') . " DH enregistré dans les dépenses).");
    }

    private function reconcileMissingCommissions()
    {
        // Reconcile missing commissions for orders that have agent_id but no commission row
        $orders = Order::doesntHave('commission')
            ->whereNotNull('agent_id')
            ->with(['items'])
            ->get();

        foreach ($orders as $order) {
            $totalComm = 0;
            foreach ($order->items as $item) {
                $totalComm += ($item->quantity * ($item->commission_agent ?? 0));
            }

            if ($totalComm > 0) {
                Commission::create([
                    'agent_id' => $order->agent_id,
                    'order_id' => $order->id,
                    'rate' => 0,
                    'amount' => $totalComm,
                    'status' => 'pending',
                ]);
            }
        }
    }
}
