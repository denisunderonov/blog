<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Просмотр списка статей - доступен всем
     */
    public function viewAny(?User $user): bool //пользователя может даже не существовать
    {
        return true; // Список статей доступен всем, даже гостям
    }

    /**
     * Просмотр отдельной статьи - доступен всем
     */
    public function view(?User $user, Article $article): bool
    {
        return true; // Просмотр статьи доступен всем
    }

    /**
     * Создание статьи - только модераторы
     */
    public function create(User $user): bool
    {
        return $user->isModerator();
    }

    /**
     * Редактирование статьи - только модераторы
     */
    public function update(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    /**
     * Удаление статьи - только модераторы
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }
}
