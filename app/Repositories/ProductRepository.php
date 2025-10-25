<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Implementasi ProductRepositoryInterface. 
 * Bertanggung jawab langsung atas operasi CRUD di database.
 */

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Model Product
     * @var Product
     */
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllProducts(): Collection
    {
        // Memuat relasi category dan supplier
        return $this->model->with(['category', 'supplier'])->latest()->get();
    }

    public function getProductById(int $productId): ?Model
    {
        return $this->model->with(['category', 'supplier'])->find($productId);
    }

    public function createProduct(array $details): Model
    {
        // Menambahkan created_by secara otomatis (asumsi auth()->id() tersedia)
        $details['created_by'] = auth()->id(); 
        return $this->model->create($details);
    }

    public function updateProduct(int $productId, array $newDetails): bool
    {
        return $this->model->whereId($productId)->update($newDetails);
    }

    public function deleteProduct(int $productId): bool
    {
        return $this->model->destroy($productId);
    }

    public function searchProducts(array $filters): Collection
    {
        $query = $this->model->with(['category', 'supplier']);

        if (isset($filters['keyword'])) {
            $query->where('name', 'like', '%' . $filters['keyword'] . '%')
                  ->orWhere('sku', 'like', '%' . $filters['keyword'] . '%');
        }
        
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Tambahkan filter lain sesuai kebutuhan laporan
        return $query->get();
    }
}
