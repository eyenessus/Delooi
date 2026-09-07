<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\DTO\ProductData;
use App\Models\Produto;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly Produto $model) {}

    public function all(): Collection
    {
        return $this->model->with('user')->latest()->get();
    }

    public function create(ProductData $data): Produto
    {
        return $this->model->create([
            'user_id' => $data->userId,
            'name' => $data->name,
            'photo' => $data->photo,
            'price' => $data->price,
        ]);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get()->keyBy('id');
    }
}
