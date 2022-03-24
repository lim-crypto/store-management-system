<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Type extends Model
{
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function breed()
    {
        return $this->hasMany(Breed::class);
    }
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
