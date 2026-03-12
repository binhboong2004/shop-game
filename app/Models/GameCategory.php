<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id', 'name', 'slug', 'description', 'image', 'status'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
