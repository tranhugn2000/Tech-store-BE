<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\FileUploadService;
class ProductService
{
    private $product;
    private $fileUploadService;

    function __construct(Product $product, FileUploadService $fileUploadService)
    {
        $this->product = $product;
        $this->fileUploadService = $fileUploadService;
    }

    public function getListProduct($data)
    {
        $products = Product::all();
        // $products->map(function ($product) {
        //     $product->action = view('products.elements.actions', ['productId' => $product->id])->render();
        // });
        return [
            'result' => $products,
        ];
    }

    public function createProduct($data)
    {
        if (isset($data)) {
        $data['remaining_quantity'] = $data['quantity'];
        $product = $this->product->create($data);

        $tempFolder = 'products/';
        $files = $this->fileUploadService->getAllTempFile($tempFolder);
        foreach ($files as $file) {
            Storage::move($file, 'public/uploads/products/' . basename($file));
            $dataFile['file_path']   = 'uploads/products/' . basename($file);

            $product->productImages()->create($dataFile);
        }
        Storage::delete($files);
        }
    }
}
