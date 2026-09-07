<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\DTO\OrderData;
use App\DTO\OrderItemData;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CheckoutService
{
    public function __construct(private readonly OrderRepositoryInterface $orders) {}

    public function checkout(User $user, Collection $products): void
    {
        $items = $products->map(fn ($product): OrderItemData => new OrderItemData(
            productId: $product->id,
            productName: $product->name,
            unitPrice: (float) $product->price,
            quantity: $product->cart_quantity,
            subtotal: (float) $product->cart_subtotal,
        ))->all();

        $total = (float) $products->sum('cart_subtotal');
        $this->orders->create(new OrderData(
            userId: $user->id,
            total: $total,
            items: $items,
        ));
        Session::forget('cart');
    }
}
