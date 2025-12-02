<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Заголовок новости
            $table->string('slug')->unique(); // ЧПУ для URL
            $table->text('content'); // Полный текст новости
            $table->string('image')->nullable(); // Путь к изображению
            $table->timestamp('published_at')->nullable(); // Дата публикации
            $table->boolean('is_published')->default(false); // Опубликована ли
            $table->unsignedInteger('views_count')->default(0); // Количество просмотров
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Автор
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
