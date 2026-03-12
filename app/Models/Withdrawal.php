<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'amount', 'bank_name', 'account_number', 
        'account_name', 'note', 'status'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
