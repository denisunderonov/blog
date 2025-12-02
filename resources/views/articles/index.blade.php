@extends('layouts.app')

@section('title', 'Новости')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0;">Все новости</h1>
        
        @can('create', App\Models\Article::class)
            <a href="{{ route('articles.create') }}" class="btn btn--primary">Создать статью</a>
        @endcan
    </div>

    @if($articles->count() > 0)
        <div class="articles-grid">
            @foreach($articles as $article)
                <article class="article-card">
                    @if($article->image)
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="article-card__image">
                    @endif
                    
                    <div class="article-card__content">
                        <h2 class="article-card__title">
                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h2>
                        
                        <div class="article-card__meta">
                            <span class="article-card__date">{{ $article->published_at ? $article->published_at->format('d.m.Y') : 'Не опубликовано' }}</span>
                            <span class="article-card__views">{{ $article->views_count }}</span>
                            <span class="article-card__author">{{ $article->user->name }}</span>
                        </div>
                        
                        <p class="article-card__excerpt">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                        
                        <a href="{{ route('articles.show', $article->slug) }}" class="btn btn--primary">Читать далее</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="pagination">
            <div class="pagination-container">
                @if ($articles->onFirstPage())
                    <span class="pagination-btn pagination-btn--disabled">← Назад</span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="pagination-btn">← Назад</a>
                @endif

                <span class="pagination-info">
                    Страница {{ $articles->currentPage() }} из {{ $articles->lastPage() }}
                </span>

                @if ($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="pagination-btn">Вперёд →</a>
                @else
                    <span class="pagination-btn pagination-btn--disabled">Вперёд →</span>
                @endif
            </div>
        </div>
    @else
        <p class="empty-message">Пока нет опубликованных новостей.</p>
    @endif
</div>
@endsection