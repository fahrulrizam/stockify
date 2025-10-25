<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    public function getAllProducts(): Collection;
    public function getProductById(int $productId): ?Model;
    public function createProduct(array $details): Model;
    public function updateProduct(int $productId, array $newDetails): bool;
    public function deleteProduct(int $productId): bool;
    public function searchProducts(array $filters): Collection;
}
