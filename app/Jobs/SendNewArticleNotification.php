<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewArticleNotification;

class SendNewArticleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $article;

    /**
     * Создать новый экземпляр задания
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Выполнить задание
     */
    public function handle(): void
    {
        // Получаем всех модераторов
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        // Отправляем письмо каждому модератору
        foreach ($moderators as $moderator) {
            try {
                Mail::to($moderator->email)->send(new NewArticleNotification($this->article));
                \Log::info('Email sent to: ' . $moderator->email);
            } catch (\Exception $e) {
                \Log::error('Failed to send email to ' . $moderator->email . ': ' . $e->getMessage());
            }
        }
    }
}