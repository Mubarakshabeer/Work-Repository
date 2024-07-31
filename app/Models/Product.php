<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // A product can have many product images
    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
