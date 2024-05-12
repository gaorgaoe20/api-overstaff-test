<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'img'
    ];


    /**
     * Get the carts that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_products');
    }

}
