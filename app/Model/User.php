<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'contact_number', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function shipping_addresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
