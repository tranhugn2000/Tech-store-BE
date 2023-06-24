<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Filters\CategoryFilter;

class Category extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function modelFilter(): ?string
    {
        return $this->provideFilter(CategoryFilter::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
