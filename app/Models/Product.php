<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'title',
        'description',
        'price',
        'old_price',
        'rating',
        'reviews_count',
        'delivery_date',
        'image'
    ];
}