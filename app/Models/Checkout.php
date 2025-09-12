<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'company',
        'street',
        'apartment',
        'city',
        'phone',
        'email',
        'payment',
    ];
}
