<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id","product_id","cart_report_id","price","sub_total","qty","discount","cart_code","status","tab_no"
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function cartReport(){
        return $this->belongsTo(CartReport::class);
    }
}