<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'variable_name', 'type', 'options', 'status'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_attribute');
    }

    public function accountAttributes()
    {
        return $this->hasMany(AccountAttribute::class);
    }
}
