<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
