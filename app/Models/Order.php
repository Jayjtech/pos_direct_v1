<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'combined_order_id',
        'user_id',
        'product_id',
        'product',
        'product_code',
        'barcode',
        'qty',
        'unit_price',
        'sub_cost_price',
        'sub_selling_price',
        'sub_total',
        'discount',
    ];

    public function combinedOrder(){
        return $this->belongsTo(CombinedOrder::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}