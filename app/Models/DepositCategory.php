<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepositCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'image',
        'details',
        'status',
    ];

    protected $casts = [
        'details' => 'array',
        'status' => 'boolean',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}
