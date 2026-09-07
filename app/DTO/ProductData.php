<?php

namespace App\DTO;

class ProductData
{
    public function __construct(public int $userId, public string $name, public float $price, public ?string $photo = null) {}

    public function withPhoto(string $photo): self
    {
        return new self($this->userId, $this->name, $this->price, $photo);
    }
}
