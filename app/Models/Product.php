<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name","cost_price","price", "availability","product_code","img","category_id","discount_amount","discount_percent","discount_mode",
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stock(){
        return $this->hasMany(Stock::class);
    }
}