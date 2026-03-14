<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyWheel extends Model
{
    protected $table = 'lucky_wheels';

    protected $fillable = [
        'game_id',
        'name',
        'image',
        'price',
        'status',
        'description',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function prizes()
    {
        return $this->hasMany(WheelPrize::class, 'lucky_wheel_id');
    }
}
