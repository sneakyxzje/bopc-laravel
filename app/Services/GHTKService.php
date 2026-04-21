<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GHTKService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = config('services.ghtk.token');
        $this->baseUrl = config('services.ghtk.base_url');
    }

    public function calculateFee($data)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Token' => $this->token,
        ])->get($this->baseUrl . '/services/shipment/fee', $data);
        return $response->json();
    }

    public function createOrder($orderData)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Token' => $this->token,
        ])->post($this->baseUrl . '/services/shipment/order', $orderData);
        return $response->json();
    }
}
