<?php

namespace App\Repositories;

interface PaymentTransactionRepositoryInterface
{
    public function create_order(array $data);
    public function get_order_by_id(string $order_id);
}
