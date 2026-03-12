<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'prize_id', 'spin_cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prize()
    {
        return $this->belongsTo(WheelPrize::class, 'prize_id');
    }
}
