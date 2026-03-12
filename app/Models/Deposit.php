<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'deposit_category_id', 'amount', 'received_amount', 'card_network', 
        'card_pin', 'card_serial', 'transaction_id', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DepositCategory::class, 'deposit_category_id');
    }
}
