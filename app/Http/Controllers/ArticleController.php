<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Str;
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

        // Если slug не указан, генерируем из заголовка
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Добавляем ID текущего пользователя (пока захардкодим 1)
        $validated['user_id'] = 1; // Потом заменим на auth()->id()

        // Если is_published не передан, ставим false
        $validated['is_published'] = $validated['is_published'] ?? false;

        // Создаём статью
        $article = Article::create($validated);

        // Редирект на страницу созданной статьи с сообщением
        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Статья успешно создана!');
    }

    public function show(string $slug)
    {
        $article = Article::with(['user', 'comments.user'])
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

        // Обновляем is_published
        $validated['is_published'] = $validated['is_published'] ?? false;

        // Обновляем статью
        $article->update($validated);

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
