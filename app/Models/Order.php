<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'seller_id', 'account_id', 'amount', 'discount_amount',
        'discount_code_id', 'status'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }
}
