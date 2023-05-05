<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private $product;

    function __construct(Product $product){
        $this->product = $product;
    }

    public function createProduct($data)
    {
        $product = $this->product->create($data);

        $imageType = ['png', 'jpg', 'jpeg', 'gif'];
        if (isset($data['code'])) {
            if (isset($data['imageIds'])) {
                $product->fieldCertificateFiles()->whereNotIn('id', $data['imageIds'])->delete();
            }

            if (isset($data['files'])) {
                $this->fileUploadService->updateMultipleFiles($product, $data);
            } else {
                $tempFolder = 'products/';
                $files = $this->fileUploadService->getAllTempFile($tempFolder);
                foreach ($files as $file) {
                    Storage::move($file, 'public/uploads/products/' . basename($file));
                    $dataFile['file_path']   = 'uploads/products/' . basename($file);

                    $dataFile['type'] = config('constant.video_type');
                    if (in_array(pathinfo($file)['extension'], $imageType)) {
                        $dataFile['type'] = config('constant.image_type');
                    }
                    $product->productImages()->create($dataFile);
                }
                Storage::delete($files);
            }
        } else {
            $this->fieldCertificateFile->where('field_id', $field->id)->delete();
        }
    }
}
