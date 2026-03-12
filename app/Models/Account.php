<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_category_id', 'seller_id', 'title', 'price', 
        'original_price', 'account_username', 'account_password', 
        'description', 'images', 'status', 
        'buyer_id', 'sold_at', 'badge'
    ];

    protected $casts = [
        'images' => 'array',
        'sold_at' => 'datetime',
    ];

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function accountAttributes()
    {
        return $this->hasMany(AccountAttribute::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
