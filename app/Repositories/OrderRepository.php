<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\DTO\OrderData;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private readonly Order $model,
    ) {}

    public function create(OrderData $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $order = $this->model->create([
                'user_id' => $data->userId,
                'total' => $data->total,
                'status' => $data->status,
            ]);

            $order->items()->createMany(array_map(fn ($item): array => $item->toArray(), $data->items));

            return $order->load('items');
        });
    }
}
