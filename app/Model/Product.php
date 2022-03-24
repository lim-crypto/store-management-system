<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'image', 'name',  'description', 'price', 'quantity',
    ];

    public function saveImage($image)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('images/products', $imageName, 'public');
        return $imageName;
    }
    public function deleteImage($image)
    {
        if ($image) {
            Storage::delete('/public/images/products/' . $image);
        }
        return;
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
