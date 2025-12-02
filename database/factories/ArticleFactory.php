<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6), // Заголовок из 6 слов
            'slug' => fake()->unique()->slug(), // Уникальный slug для URL
            'content' => fake()->paragraphs(5, true), // 5 параграфов текста
            'image' => fake()->imageUrl(640, 480, 'articles', true), // Ссылка на картинку
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'), // Дата за последний год
            'is_published' => fake()->boolean(80), // 80% шанс что опубликовано
            'views_count' => fake()->numberBetween(0, 10000), // От 0 до 10000 просмотров
            'user_id' => \App\Models\User::factory(), // Создаёт связанного пользователя
        ];
    }
}
