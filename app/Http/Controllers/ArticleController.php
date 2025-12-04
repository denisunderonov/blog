<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**

     */
    public function index()
    {
        $articles = Article::with('user')
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6); // 6 статей на страницу

        return view('articles.index', compact('articles'));
    }

    /**
     * Показать форму создания статьи
     */
    public function create()
    {
        $this->authorize('create', Article::class);

        return view('articles.create');
    }

    /**
     * Сохранить новую статью
     */
    public function store(StoreArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validated();

        // Временный дебаг: смотрим входные данные
        \Log::info('Article store request', [
            'payload' => $request->all(),
        ]);

        // Если slug не указан, генерируем из заголовка
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Добавляем ID текущего пользователя
        $validated['user_id'] = auth()->id();

    // Корректно читаем чекбокс публикации
    $validated['is_published'] = $request->boolean('is_published');

        // Если публикация включена и дата не задана — проставим текущее время
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Создаём статью
        $article = Article::create($validated);

        // Временный дебаг: итоговое значение публикации
        \Log::info('Article created', [
            'id' => $article->id,
            'is_published' => $article->is_published,
            'published_at' => $article->published_at,
        ]);

        // Поставить задание отправки писем в очередь
        \App\Jobs\SendNewArticleNotification::dispatch($article);
        
        // Транслировать событие о новой статье (real-time уведомление)
        event(new \App\Events\NewArticleEvent($article));
        
        // Редирект: если опубликована - на страницу статьи, иначе - на главную
        if ($article->is_published) {
            return redirect()
                ->route('articles.show', $article->slug)
                ->with('success', 'Статья успешно создана и опубликована!');
        }
        
        return redirect()
            ->route('home')
            ->with('success', 'Статья создана как черновик!');
    }

    public function show(string $slug)
    {
        $article = Article::with(['user', 'comments' => function ($q) {
                $q->where('is_approved', true)->with('user')->orderBy('created_at');
            }])
            ->where('slug', $slug) // Поиск по slug
            ->where('is_published', true) // Только опубликованные статьи
            ->firstOrFail(); // Если не найдено - 404 ошибка

        // Увеличиваем счётчик просмотров
        $article->increment('views_count');

        return view('articles.show', compact('article'));
    }

    /**
     * Показать форму редактирования статьи
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    /**
     * Обновить статью
     */
    public function update(UpdateArticleRequest $request, string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('update', $article);

        // Получаем валидированные данные
        $validated = $request->validated();

        // Если slug изменился, обновляем
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Корректно читаем чекбокс публикации
        $validated['is_published'] = $request->boolean('is_published');

        // Если включили публикацию и нет даты — ставим текущее время
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Если сняли публикацию — обнулим дату публикации
        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        // Обновляем статью
        $article->update($validated);

        // Временный дебаг: результат обновления
        \Log::info('Article updated', [
            'id' => $article->id,
            'is_published' => $article->is_published,
            'published_at' => $article->published_at,
        ]);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Статья успешно обновлена!');
    }

    /**
     * Удалить статью
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Статья успешно удалена!');
    }
}
