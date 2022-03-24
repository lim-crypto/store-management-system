<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'products',  'shipping_address', 'packing_time', 'delivery_time', 'arrival_time', 'status', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
