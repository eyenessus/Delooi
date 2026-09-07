<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\DTO\ProductData;
use App\Models\Produto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $products) {}

    public function list(): Collection
    {
        return $this->products->all();
    }

    public function create(ProductData $data, ?UploadedFile $photo): Produto
    {
        if ($photo) {
            $data = $data->withPhoto($photo->store('products', 'public'));
        }

        return $this->products->create($data);
    }

    public function cart(array $cart): Collection
    {
        $products = $this->products->findByIds(array_keys($cart));

        return $products->map(function (Produto $product) use ($cart): Produto {
            $product->cart_quantity = (int) $cart[$product->id];    
            $product->cart_subtotal = $product->price * $product->cart_quantity;

            return $product;
        });
    }

    public function removePhoto(Produto $product): void
    {
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
    }
}
