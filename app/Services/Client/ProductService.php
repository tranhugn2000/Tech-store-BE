<?php

namespace App\Services\Client;

use App\Models\Product;

class ProductService
{
    function __construct()
    {
    }
    public function getProduct()
    {
        $products = Product::with('productImages')->get();
        return $products;
    }
    //
}
