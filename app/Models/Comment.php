<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\User;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
    'article_id',
    'user_id',
    'content',
];

public function article()
{
    return $this->belongsTo(Article::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
