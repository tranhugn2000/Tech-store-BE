<?php

namespace App\Models;

use App\Models\Filters\ProductFilter;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'quantity',
        'remaining_quantity',
    ];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category() {
        return $this->belongsTo(Product::class);
    }

    public function billDetails() 
    {
        return $this->hasMany(BillDetail::class);
    }

    public function modelFilter(): ?string
    {
        return $this->provideFilter(ProductFilter::class);
    }
}
