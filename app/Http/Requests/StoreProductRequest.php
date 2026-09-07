<?php

namespace App\Http\Requests;

use App\DTO\ProductData;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function toData(int $userId): ProductData
    {
        return new ProductData(
            userId: $userId,
            name: $this->string('name')->toString(),
            price: $this->float('price'),
        );
    }
}
