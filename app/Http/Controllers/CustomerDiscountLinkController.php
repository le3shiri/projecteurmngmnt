<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDiscountLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerDiscountLinkController extends Controller
{
    /**
     * Generate or regenerate a VIP discount link for a customer.
     * Only callable by super admin.
     */
    public function generate(Request $request, Customer $customer)
    {
        $user = auth()->user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Seul le super administrateur est autorisé à générer le lien fidélité client.');
        }

        if (!$customer->hasDeliveredOrder()) {
            return back()->with('error', 'Ce client n\'a pas encore de commande au statut "Livrée". Le lien fidélité est réservé aux clients ayant déjà reçu leur projecteur.');
        }

        $firstAgent = $customer->getFirstAgent();

        $link = $customer->latestDiscountLink;
        if (!$link || $request->has('regenerate')) {
            $link = CustomerDiscountLink::create([
                'customer_id' => $customer->id,
                'token' => Str::random(48),
                'created_by' => $user->id,
                'admin_id' => $user->id,
                'first_agent_id' => $firstAgent ? $firstAgent->id : null,
                'discount_initial' => 11.00,
                'discount_permanent' => 5.00,
                'initial_duration_days' => 10,
            ]);
        }

        return back()->with('success', 'Lien exclusif fidélité généré avec succès pour ' . $customer->name . ' !')
                     ->with('vip_link_url', $link->getUrl());
    }
}

