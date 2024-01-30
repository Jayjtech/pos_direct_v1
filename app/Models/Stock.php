<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "product_id", "product", "product_code", "barcode", "qty_requested", "status"
    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}