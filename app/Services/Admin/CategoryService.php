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


    public function getCategory()
    {
        $categories = $this->category->get();

        return $categories;
    }

    public function createCategory($data)
    {
        if (isset($data)) {
            $this->category->create($data);
        }
    }

    public function getListCategory($data)
    {
        $data['order'] = $data['order'][0];
        $model = $this->getCategoryFilters($data);
        $recordsTotal = $model->count();
        $categories = $model->offset($data['start'])
            ->limit($data['length'])
            ->get();
        $categories->map(function ($category) {
            $category->name = limitCharacter($category->name, 30);  
            $category->action = view('categories.elements.actions', ['categoryId' => $category->id])->render();
        });

        return [
            'result' => $categories,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal
        ];
    }

    public function getCategoryFilters($data)
    {
        $categories = $this->category->filter($data);

        return $categories;
    }
}
