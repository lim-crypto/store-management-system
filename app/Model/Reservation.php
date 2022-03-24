<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    public function pet(){
      return  $this->belongsTo(Pet::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
