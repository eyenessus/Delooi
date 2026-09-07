<?php

namespace App\DTO;

final readonly class OrderData
{
    public function __construct(
        public int $userId,
        public float $total,
        public array $items,
        public string $status = 'paid',
    ) {}
}
