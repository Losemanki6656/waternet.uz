<?php

namespace App\Services;

use App\Models\ClientPrices;
use App\Models\EntryContainer;
use App\Models\SuccessOrders;
use App\Models\TakeProduct;
use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get payment & operational stats for a given date.
     * Replaces 5 separate ClientPrices queries with one conditional-SUM query.
     */
    public function getStats(int $orgId, Carbon $date): array
    {
        $payments = ClientPrices::where('organization_id', $orgId)
            ->whereDate('created_at', $date)
            ->selectRaw('
                COALESCE(SUM(amount), 0)                                              AS total,
                COALESCE(SUM(CASE WHEN payment = 1 THEN amount ELSE 0 END), 0)       AS cash,
                COALESCE(SUM(CASE WHEN payment = 2 THEN amount ELSE 0 END), 0)       AS card,
                COALESCE(SUM(CASE WHEN payment = 3 THEN amount ELSE 0 END), 0)       AS transfer,
                COALESCE(SUM(CASE WHEN payment NOT IN (1,2,3) THEN amount ELSE 0 END), 0) AS other
            ')
            ->first();

        $debt = SuccessOrders::where('organization_id', $orgId)
            ->whereDate('created_at', $date)
            ->whereIn('order_status', [1, 2])
            ->where('price_sold', '<', 0)
            ->sum('price_sold');

        $ordersCount = SuccessOrders::where('organization_id', $orgId)
            ->whereDate('created_at', $date)
            ->whereIn('order_status', [1, 2])
            ->sum('count');

        $total = (float) ($payments->total ?? 0);

        return [
            'amount'          => $total,
            'amount_cash'     => (float) ($payments->cash ?? 0),
            'amount_card'     => (float) ($payments->card ?? 0),
            'amount_transfer' => (float) ($payments->transfer ?? 0),
            'amount_other'    => (float) ($payments->other ?? 0),
            'debt'            => abs((float) $debt),
            'orders_count'    => (int) $ordersCount,
            'pct_cash'        => $total > 0 ? round(($payments->cash / $total) * 100) : 0,
            'pct_card'        => $total > 0 ? round(($payments->card / $total) * 100) : 0,
            'pct_transfer'    => $total > 0 ? round(($payments->transfer / $total) * 100) : 0,
            'pct_other'       => $total > 0 ? round(($payments->other / $total) * 100) : 0,
        ];
    }

    /**
     * Build the per-user performance table for a given date.
     * Uses three aggregated whereIn queries (no N+1).
     */
    public function getUserTable(int $orgId, Carbon $date): array
    {
        $users   = User::where('organization_id', $orgId)->get();
        $userIds = $users->pluck('id');

        $takeProductTotals = TakeProduct::whereDate('created_at', $date)
            ->whereIn('received_id', $userIds)
            ->selectRaw('received_id, SUM(product_count) as total')
            ->groupBy('received_id')
            ->pluck('total', 'received_id');

        $successOrderTotals = SuccessOrders::whereDate('created_at', $date)
            ->whereIn('user_id', $userIds)
            ->whereIn('order_status', [1, 2])
            ->selectRaw('user_id, SUM(count) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $entryContainerTotals = EntryContainer::whereDate('created_at', $date)
            ->whereIn('user_id', $userIds)
            ->selectRaw('user_id, SUM(product_count) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        return $users->map(fn($user) => [
            'name'      => $user->name,
            'role'      => $user->roleName(),
            'takeProd'  => (int) $takeProductTotals->get($user->id, 0),
            'suc_order' => (int) $successOrderTotals->get($user->id, 0),
            'ectryCon'  => (int) $entryContainerTotals->get($user->id, 0),
        ])->all();
    }
}
