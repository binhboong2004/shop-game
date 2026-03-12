<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelPrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'type', 'value', 'probability', 'status'
    ];

    public function histories()
    {
        return $this->hasMany(WheelHistory::class, 'prize_id');
    }
}
