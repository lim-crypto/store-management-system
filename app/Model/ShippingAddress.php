<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id', 'houseNumber', 'street', 'brgy', 'city', 'province', 'country',
    ];
    public function completeAddress()
    {
        return "{$this->houseNumber} {$this->street}  {$this->brgy}, {$this->city}, {$this->province}, {$this->country}";
    }
}
