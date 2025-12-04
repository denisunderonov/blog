@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
<div class="container">
    <section class="comments-section">
        <h2 class="comments-section__title">Комментарии на модерации</h2>

        @if(session('success'))
            <div class="alert alert--success">{{ session('success') }}</div>
        @endif

        @if($comments->isEmpty())
            <p class="comments-section__empty">Нет комментариев, ожидающих модерации.</p>
        @else
            <div class="comments-list">
                @foreach($comments as $comment)
                    <div class="comment comment--moderation">
                        <div class="comment__header">
                            <div>
                                <span class="comment__author">{{ $comment->user->name ?? 'Гость' }}</span>
                                <span class="comment__meta">на статье</span>
                                <a href="{{ route('articles.show', $comment->article->slug) }}" target="_blank" class="comment__article-link">
                                    {{ $comment->article->title }}
                                </a>
                            </div>
                            <span class="comment__date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        
                        <div class="comment__content">
                            {{ $comment->content }}
                        </div>

                        <div class="comment__actions">
                            <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="comment__action-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="comment__approve-btn">Принять</button>
                            </form>
                            <form action="{{ route('comments.decline', $comment->id) }}" method="POST" class="comment__action-form" onsubmit="return confirm('Отклонить и удалить этот комментарий?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="comment__delete-btn">Отклонить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                <div class="pagination-container">
                    @if ($comments->onFirstPage())
                        <span class="pagination-btn pagination-btn--disabled">← Назад</span>
                    @else
                        <a href="{{ $comments->previousPageUrl() }}" class="pagination-btn">← Назад</a>
                    @endif

                    <span class="pagination-info">
                        Страница {{ $comments->currentPage() }} из {{ $comments->lastPage() }}
                    </span>

                    @if ($comments->hasMorePages())
                        <a href="{{ $comments->nextPageUrl() }}" class="pagination-btn">Вперёд →</a>
                    @else
                        <span class="pagination-btn pagination-btn--disabled">Вперёд →</span>
                    @endif
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
