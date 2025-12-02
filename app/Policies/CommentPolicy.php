<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Просмотр списка комментариев - доступен всем
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Просмотр комментария - доступен всем
     */
    public function view(?User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Создание комментария - только авторизованные пользователи
     */
    public function create(User $user): bool
    {
        return true; // Все авторизованные пользователи могут комментировать
    }

    /**
     * Редактирование комментария - модератор или автор комментария
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->isModerator() || $user->id === $comment->user_id;
    }

    /**
     * Удаление комментария - модератор или автор комментария
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->isModerator() || $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
