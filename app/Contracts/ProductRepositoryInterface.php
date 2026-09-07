<?php

namespace App\Contracts;

use App\DTO\ProductData;
use App\Models\Produto;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;

    public function create(ProductData $data): Produto;

    public function findByIds(array $ids): Collection;
}
