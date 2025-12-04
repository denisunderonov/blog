<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request, $articleId)
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        // Получаем статью, чтобы потом использовать её slug
        $article = \App\Models\Article::findOrFail($articleId);

        $comment = Comment::create([
            'article_id' => $articleId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_approved' => false,
        ]);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Комментарий отправлен и ожидает модерации.');
    }


    public function show(Comment $comment)
    {

    }


    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        $comment->load('article'); // Загружаем связь со статьей
        return view('comments.edit', compact('comment'));
    }


    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий обновлён!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        // Получаем slug статьи для редиректа
        $articleSlug = $comment->article->slug;

        $comment->delete();

        return redirect()
            ->route('articles.show', $articleSlug)
            ->with('success', 'Комментарий удалён!');
    }

    /**
     * Список комментариев, ожидающих модерации
     */
    public function pending()
    {
        $this->authorize('viewAny', Comment::class);

        $comments = Comment::with(['user', 'article'])
            ->where('is_approved', false)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('moderation.comments', compact('comments'));
    }

    /**
     * Принять комментарий
     */
    public function approve(string $id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);

        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Комментарий принят.');
    }

    /**
     * Отклонить комментарий
     */
    public function decline(string $id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Комментарий отклонён и удалён.');
    }
}
