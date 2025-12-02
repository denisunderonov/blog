<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Article extends Model
{
    use HasFactory; // Подключаем фабрику(Возможность создавать фейковые модели с помощью фабрик)

    /**
     * Поля, которые можно массово заполнять
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'published_at',
        'is_published',
        'views_count',
        'user_id',
    ];

    /**
     * Поля, которые должны быть преобразованы в типы
     */
    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * Связь с пользователем (автором)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
