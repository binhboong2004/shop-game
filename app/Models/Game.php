<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'status'
    ];

    public function gameCategories()
    {
        return $this->hasMany(GameCategory::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'game_attribute');
    }

    public function accounts()
    {
        return $this->hasManyThrough(Account::class, GameCategory::class);
    }

    public function luckyWheels()
    {
        return $this->hasMany(LuckyWheel::class);
    }
}
