<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * Service Layer untuk Product. Menangani validasi, otorisasi, dan logika bisnis.
 */
class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Mendapatkan daftar produk untuk ditampilkan di Manajer/Admin.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductList()
    {
        // Logika bisnis: Misalnya, hanya tampilkan produk yang stoknya >= stok minimum (kecuali filter khusus)
        // Di sini, kita akan memanggil Repository.
        return $this->productRepository->getAllProducts();
    }

    /**
     * Menyimpan produk baru dengan validasi dan penanganan gambar.
     * @param array $productDetails
     * @param UploadedFile|null $imageFile
     * @return Model
     * @throws ValidationException
     */
    public function createNewProduct(array $productDetails, ?UploadedFile $imageFile = null): Model
    {
        // 1. Validasi Sederhana (Dalam proyek nyata, gunakan Request Class)
        if (empty($productDetails['name']) || empty($productDetails['sku'])) {
             // throw ValidationException::withMessages(['name' => 'Nama produk dan SKU wajib diisi.']);
             // Asumsi validasi di Controller atau Request sudah dilakukan
        }

        // 2. Transaksi Database
        return DB::transaction(function () use ($productDetails, $imageFile) {
            
            // 3. Penanganan Gambar
            if ($imageFile) {
                $productDetails['image_path'] = $this->handleImageUpload($imageFile, 'products');
            } else {
                 $productDetails['image_path'] = null;
            }

            // 4. Panggil Repository untuk menyimpan data
            return $this->productRepository->createProduct($productDetails);
        });
    }

    /**
     * Fungsi helper untuk upload gambar.
     */
    protected function handleImageUpload(UploadedFile $file, string $directory): string
    {
        // Simpan file ke storage/app/public/{directory}
        $path = $file->store($directory, 'public');
        return $path;
    }

    // ... Metode updateProduct, deleteProduct, dll., akan memiliki logika serupa ...
}
