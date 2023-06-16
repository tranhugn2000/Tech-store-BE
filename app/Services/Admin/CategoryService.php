<?php

namespace App\Services\Admin;
use App\Models\Category;

class CategoryService
{
    private $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function createCategory($data)
    {
        if (isset($data)) {
            $this->category->create($data);
        }
    }
}
