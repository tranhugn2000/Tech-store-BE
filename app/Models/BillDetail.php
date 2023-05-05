<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'product_id',
        'quantity',
        'price',    
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
