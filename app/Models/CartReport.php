<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartReport extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id","grand_total",
    ];

    public function cart(){
        return $this->hasMany(Cart::class);
    }

}