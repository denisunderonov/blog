@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container">
    <article class="article-single">
        <header class="article-single__header">
            <h1 class="article-single__title">{{ $article->title }}</h1>
            
            <div class="article-single__meta">
                <span class="article-single__date">{{ $article->published_at ? $article->published_at->format('d.m.Y H:i') : 'Не опубликовано' }}</span>
                <span class="article-single__author">{{ $article->user->name }}</span>
                <span class="article-single__views">{{ $article->views_count }}</span>
            </div>
        </header>

        @if($article->image)
            <div class="article-single__image-wrapper">
                <img src="{{ $article->image }}" alt="{{ $article->title }}" class="article-single__image">
            </div>
        @endif

        <div class="article-single__content">
            {!! nl2br(e($article->content)) !!}
        </div>

        <footer class="article-single__footer">
            <a href="{{ route('home') }}" class="btn btn--secondary">← Вернуться к списку</a>
            
            @can('update', $article)
                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn--primary">Редактировать</a>
            @endcan
        </footer>
    </article>

    <!-- Секция комментариев -->
    <section class="comments-section">
        <h2 class="comments-section__title">Комментарии ({{ $article->comments->count() }})</h2>

        <!-- Форма добавления комментария -->
        <div class="comment-form">
            <h3 class="comment-form__title">Оставить комментарий</h3>
            
            <form action="{{ route('comments.store', $article->id) }}" method="POST" class="comment-form__form">
                @csrf
                
                <div class="form__group">
                    <label for="content" class="form__label">Ваш комментарий *</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        class="form__textarea @error('content') form__input--error @enderror"
                        rows="4"
                        required
                        placeholder="Напишите ваш комментарий..."
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn--primary">Отправить комментарий</button>
            </form>
        </div>

        <!-- Список комментариев -->
        @if($article->comments->count() > 0)
            <div class="comments-list">
                @foreach($article->comments as $comment)
                    <div class="comment">
                        <div class="comment__header">
                            <span class="comment__author">{{ $comment->user->name }}</span>
                            <span class="comment__date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        
                        <div class="comment__content">
                            {{ $comment->content }}
                        </div>

                        <!-- Кнопки редактирования и удаления комментария -->
                        <div class="comment__actions">
                            @can('update', $comment)
                                <a href="{{ route('comments.edit', $comment->id) }}" class="comment__edit-btn">Редактировать</a>
                            @endcan
                            
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="comment__delete-form" onsubmit="return confirm('Удалить этот комментарий?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="comment__delete-btn">Удалить</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="comments-section__empty">Пока нет комментариев. Будьте первым!</p>
        @endif
    </section>
</div>
@endsection