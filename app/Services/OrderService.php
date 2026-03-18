<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;

class OrderService
{
    /**
     * Create a single order for a client.
     * Returns null if client already has an active order for the same product.
     */
    public function createOrder(int $clientId, int $orgId, int $userId, array $data): ?Order
    {
        $exists = Order::where('client_id', $clientId)
            ->where('product_id', $data['product_id'])
            ->where('status', 0)
            ->exists();

        if ($exists) {
            return null;
        }

        $client = Client::findOrFail($clientId);

        $order                  = new Order();
        $order->organization_id = $orgId;
        $order->city_id         = $client->city_id;
        $order->area_id         = $client->area_id;
        $order->client_id       = $clientId;
        $order->product_id      = $data['product_id'];
        $order->container_status = Product::findOrFail($data['product_id'])->container_status;
        $order->product_count   = $data['count'];
        $order->price           = $data['sena'];
        $order->comment         = $data['izoh'] ?? '';
        $order->status          = 0;
        $order->user_id         = $userId;
        $order->save();

        return $order;
    }

    /**
     * Create orders for multiple clients (bulk selection).
     * Skips clients that already have an active order for the same product.
     */
    public function createBulkOrders(array $clientIds, int $orgId, int $userId, array $data): int
    {
        $productId       = $data['product_id'];
        $containerStatus = Product::findOrFail($productId)->container_status;

        // Find clients that already have a pending order for this product
        $alreadyOrdered = Order::whereIn('client_id', $clientIds)
            ->where('product_id', $productId)
            ->where('status', 0)
            ->pluck('client_id')
            ->flip();

        $clients = Client::whereIn('id', $clientIds)->get()->keyBy('id');

        $created = 0;
        foreach ($clientIds as $clientId) {
            if ($alreadyOrdered->has($clientId)) {
                continue;
            }

            $client = $clients->get($clientId);
            if (!$client) {
                continue;
            }

            $order                  = new Order();
            $order->organization_id = $orgId;
            $order->city_id         = $client->city_id;
            $order->area_id         = $client->area_id;
            $order->client_id       = $clientId;
            $order->product_id      = $productId;
            $order->container_status = $containerStatus;
            $order->product_count   = $data['count'];
            $order->price           = $data['sena'];
            $order->comment         = $data['izoh'] ?? '';
            $order->status          = 0;
            $order->user_id         = $userId;
            $order->save();

            $created++;
        }

        return $created;
    }
}
