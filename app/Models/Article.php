<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'thumbnail', 
        'type', 'status', 'author_id', 'views'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
