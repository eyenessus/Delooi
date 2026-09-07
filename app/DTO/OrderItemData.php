<?php

namespace App\DTO;

final readonly class OrderItemData
{
    public function __construct(
        public int $productId,
        public string $productName,
        public float $unitPrice,
        public int $quantity,
        public float $subtotal,
    ) {}

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'unit_price' => $this->unitPrice,
            'quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
        ];
    }
}
