<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Article;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Сначала создаём роли
        $this->call(RoleSeeder::class);
        
        // Получаем роли
        $moderatorRole = \App\Models\Role::where('name', 'moderator')->first();
        $readerRole = \App\Models\Role::where('name', 'reader')->first();
        
        // Создаём модератора
        $moderator = User::factory()->create([
            'name' => 'Модератор',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password123')
        ]);
        $moderator->roles()->attach($moderatorRole);
        
        // Создаём 10 обычных пользователей-читателей
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->roles()->attach($readerRole);
        }
        
        // Добавляем модератора в массив пользователей для создания контента
        $allUsers = $users->push($moderator);
        
        // Потом создаём 50 статей, случайно распределяя их между авторами
        $articles = Article::factory(50)->recycle($allUsers)->create();

        // Создаём 200 комментариев, используя существующих пользователей и статьи
        \App\Models\Comment::factory(200)
            ->recycle($allUsers)  // Используем существующих пользователей
            ->recycle($articles)  // Используем существующие статьи
            ->create();
    }
}
