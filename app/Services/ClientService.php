<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Organization;
use Exception;

class ClientService
{
    /**
     * Create a new client and increment organization client count.
     */
    public function create(array $data, int $orgId, int $userId): Client
    {
        $client = new Client();
        $client->organization_id = $orgId;
        $client->user_id        = $userId;
        $client->fullname       = $data['fullname'];
        $client->city_id        = $data['city_id'];
        $client->area_id        = $data['area_id'];
        $client->street         = $data['street'] ?? ' ';
        $client->home_number    = $data['home_number'] ?? ' ';
        $client->entrance       = $data['apartment_number'] ?? ' ';
        $client->floor          = $data['entrance'] ?? ' ';
        $client->apartment_number = $data['floor'] ?? ' ';
        $client->address        = $data['address'] ?? '';
        $client->bonus          = $data['bonus'] ?? '0';
        $client->balance        = 0;
        $client->container      = 0;
        $client->login          = $data['login'];
        $client->password       = $data['password'];
        $client->location       = $data['location'] ?? '0';
        $client->activated_at   = now();
        $client->phone          = $data['phone1'];
        $client->phone2         = $data['phone2'] ?? '';
        $client->save();

        Organization::where('id', $orgId)->increment('clients_count');

        return $client;
    }

    /**
     * Update an existing client's information.
     */
    public function update(Client $client, array $data): Client
    {
        $client->fullname         = $data['fullname'];
        $client->city_id          = $data['city_id'];
        $client->area_id          = $data['area_id'];
        $client->street           = $data['street'] ?? ' ';
        $client->home_number      = $data['home_number'] ?? ' ';
        $client->entrance         = $data['entrance'] ?? ' ';
        $client->floor            = $data['floor'] ?? ' ';
        $client->apartment_number = $data['apartment_number'] ?? ' ';
        $client->address          = $data['address'] ?? '';
        $client->login            = $data['login'];
        $client->password         = $data['password'];
        $client->phone            = $data['phone'];
        $client->phone2           = $data['phone2'] ?? '';

        if (!empty($data['location'])) {
            $client->location = $data['location'];
        }

        $client->save();

        return $client;
    }

    /**
     * Soft-deactivate a client and decrement organization client count.
     */
    public function deactivate(int $clientId, int $orgId): void
    {
        Client::where('id', $clientId)->update(['status' => false]);
        Organization::where('id', $orgId)->decrement('clients_count');
    }
}
