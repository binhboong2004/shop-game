<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelPrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'lucky_wheel_id', 'name', 'image', 'type', 'value', 'probability', 'status'
    ];

    public function histories()
    {
        return $this->hasMany(WheelHistory::class, 'prize_id');
    }

    public function luckyWheel()
    {
        return $this->belongsTo(LuckyWheel::class, 'lucky_wheel_id');
    }
}
