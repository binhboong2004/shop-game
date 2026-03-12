<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'attribute_id', 'value'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
