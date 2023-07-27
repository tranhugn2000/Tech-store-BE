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
        $data['order'] = $data['order'][0];
        $model = $this->getProductFilters($data);
        $recordsTotal = $model->count();
        $products = $model->offset($data['start'])
            ->limit($data['length'])
            ->get();
        $products->map(function ($product) {
            $product->name = limitCharacter($product->name, 30); 
            $product->description = limitCharacter($product->description, 30);  
            $product->price = $product->price; 
            $product->remain_quantity = $product->remaining_quantity; 
            $product->quantity = $product->quantity; 
            $product->description = $product->description; 
            $product->action = view('products.elements.actions', ['productId' => $product->id])->render();
        });

        return [
            'result' => $products,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal
        ];
    }

    public function getProductFilters($data)
    {
        $products = $this->product->filter($data);

        return $products;
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

    public function updateProduct($data, $productId)
    {
        $product = $this->getProductById($productId);
        $product->fill($data)->save();

        if (isset($data['imageIds'])) {
            $imageDelete = $product->productImages()->whereNotIn('id', $data['imageIds']);
            $filePaths = $imageDelete->pluck('file_path')->toArray();
            foreach ($filePaths as $filePath) {
                // Loại bỏ phần đường dẫn khỏi file_path
                $fileName = basename($filePath);
                // Kiểm tra xem tệp tin có tồn tại trong thư mục hay không
                if (Storage::exists('public/uploads/products/' . $fileName)) {
                    // Xóa tệp tin
                    Storage::delete('public/uploads/products/' . $fileName);
                }
            }
            $imageDelete->delete();
        }

        $tempFolder = 'products/';
        $files = $this->fileUploadService->getAllTempFile($tempFolder);
        foreach ($files as $file) {
            Storage::move($file, 'public/uploads/products/' . basename($file));
            $dataFile['file_path']   = 'uploads/products/' . basename($file);
            $product->productImages()->create($dataFile);
        }
        Storage::delete($files);
    }

    public function getProductById($id)
    {
        $products = $this->product->find($id);
        return $products;
    }

    public function deleteProductById($id)
    {
        $product = $this->getProductById($id);
        $product->delete();
    }
}
