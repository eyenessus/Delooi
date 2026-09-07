<?php

namespace App\Contracts;

use App\DTO\OrderData;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(OrderData $data): Order;
}
