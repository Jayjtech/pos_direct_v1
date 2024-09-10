<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_details',
        'payment_method',
        'grand_total',
        'user_id',
        'trx_id',
        'status',
    ];
    
    public function orders(){
        return $this->hasMany(Order::class, 'combined_order_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}