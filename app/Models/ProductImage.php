<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, Filterable, SoftDeletes;
    
    protected $fillable = [
        'product_id',
        'file_path',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
