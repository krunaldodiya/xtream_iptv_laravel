<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class PaymentTransactionRepository implements PaymentTransactionRepositoryInterface
{
    private string $api_url;

    private string $key;

    private string $secret;

    private $client;

    public function __construct()
    {
        $this->api_url = config("services.razorpay.api_url");
        $this->key = config('services.razorpay.key');
        $this->secret = config('services.razorpay.secret');

        $this->client = Http::withBasicAuth($this->key, $this->secret)->baseUrl($this->api_url);
    }

    public function create_order(array $data)
    {
        $response = $this->client->post('orders', $data);

        return $response->json();
    }

    public function get_order_by_id(string $order_id)
    {
        $response = $this->client->get("orders/{$order_id}");

        return $response->json();
    }
}
