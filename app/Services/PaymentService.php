<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientContainer;
use App\Models\ClientPrices;
use App\Models\SuccessOrders;

class PaymentService
{
    // -------------------------------------------------------------------------
    // Client Payments (balance)
    // -------------------------------------------------------------------------

    public function addPayment(int $clientId, int $orgId, int $userId, array $data): ClientPrices
    {
        $payment                  = new ClientPrices();
        $payment->organization_id = $orgId;
        $payment->success_order_id = 0;
        $payment->client_id       = $clientId;
        $payment->user_id         = $userId;
        $payment->payment         = $data['payment'];
        $payment->amount          = $data['amount'];
        $payment->comment         = $data['comment'] ?? '';
        $payment->status          = 1;
        $payment->save();

        Client::where('id', $clientId)->increment('balance', $data['amount']);

        return $payment;
    }

    public function updatePayment(int $priceId, array $data): void
    {
        $payment  = ClientPrices::findOrFail($priceId);
        $oldAmount = $payment->amount;

        $payment->payment = $data['payment'];
        $payment->amount  = $data['amount'];
        $payment->comment = $data['comment'] ?? '';
        $payment->save();

        $diff = $data['amount'] - $oldAmount;
        Client::where('id', $payment->client_id)->increment('balance', $diff);

        // When linked to a delivered order, sync the order's price_sold
        if ($payment->status != 1) {
            $order = SuccessOrders::findOrFail($payment->success_order_id);
            $order->amount     = $data['amount'];
            $order->price_sold = $data['amount'] - ($order->count * $order->price);
            $order->save();
        }
    }

    public function deletePayment(int $priceId): void
    {
        $payment = ClientPrices::findOrFail($priceId);

        Client::where('id', $payment->client_id)->decrement('balance', $payment->amount);

        $payment->delete();
    }

    // -------------------------------------------------------------------------
    // Container Returns
    // -------------------------------------------------------------------------

    public function addContainerReturn(int $clientId, int $orgId, int $userId, array $data): ClientContainer
    {
        $record                   = new ClientContainer();
        $record->organization_id  = $orgId;
        $record->success_order_id = 0;
        $record->client_id        = $clientId;
        $record->user_id          = $userId;
        $record->product_id       = $data['product_id'];
        $record->count            = $data['count'];
        $record->invalid_count    = $data['invalid_count'];
        $record->comment          = $data['comment'] ?? '';
        $record->status           = 1;
        $record->save();

        $net = $data['count'] - $data['invalid_count'];
        Client::where('id', $clientId)->increment('container', $net);

        return $record;
    }

    public function updateContainerReturn(int $id, array $data): void
    {
        $record   = ClientContainer::findOrFail($id);
        $oldNet   = $record->count - $record->invalid_count;

        $record->product_id    = $data['product_id'];
        $record->count         = $data['count'];
        $record->invalid_count = $data['invalid_count'];
        $record->comment       = $data['comment'] ?? '';
        $record->save();

        $newNet = $data['count'] - $data['invalid_count'];
        $diff   = $newNet - $oldNet;
        Client::where('id', $record->client_id)->increment('container', $diff);

        // When linked to a delivered order, sync container counts
        if ($record->status != 1) {
            $order = SuccessOrders::findOrFail($record->success_order_id);
            $order->container              = $data['count'];
            $order->invalid_container_count = $data['invalid_count'];
            $order->save();
        }
    }

    public function deleteContainerReturn(int $id): void
    {
        $record = ClientContainer::findOrFail($id);
        $net    = $record->count - $record->invalid_count;

        Client::where('id', $record->client_id)->decrement('container', $net);

        $record->delete();
    }
}
