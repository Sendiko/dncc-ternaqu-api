<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desctription',
        'benefits',
        'brand',
        'store_id',
        'product_id',
    ];
}
