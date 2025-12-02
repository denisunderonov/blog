@extends('layouts.app')

@section('title', 'Редактировать статью')

@section('content')
<div class="container">
    <div class="form-wrapper">
        <h1 class="form-title">Редактировать статью</h1>

        <form action="{{ route('articles.update', $article->id) }}" method="POST" class="article-form">
            @csrf
            @method('PUT')

            <div class="form__group">
                <label for="title" class="form__label">Заголовок *</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form__input @error('title') form__input--error @enderror"
                    value="{{ old('title', $article->title) }}"
                    required
                >
                @error('title')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="slug" class="form__label">Slug (URL)</label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    class="form__input @error('slug') form__input--error @enderror"
                    value="{{ old('slug', $article->slug) }}"
                >
                @error('slug')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="content" class="form__label">Содержание *</label>
                <textarea 
                    id="content" 
                    name="content" 
                    class="form__textarea @error('content') form__input--error @enderror"
                    rows="10"
                    required
                >{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="image" class="form__label">URL изображения</label>
                <input 
                    type="url" 
                    id="image" 
                    name="image" 
                    class="form__input @error('image') form__input--error @enderror"
                    value="{{ old('image', $article->image) }}"
                >
                @error('image')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="published_at" class="form__label">Дата публикации</label>
                <input 
                    type="datetime-local" 
                    id="published_at" 
                    name="published_at" 
                    class="form__input @error('published_at') form__input--error @enderror"
                    value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                >
                @error('published_at')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group form__group--checkbox">
                <label class="form__checkbox-label">
                    <input 
                        type="checkbox" 
                        name="is_published" 
                        value="1"
                        {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                    >
                    <span>Опубликовано</span>
                </label>
            </div>

            <div class="form__actions">
                <button type="submit" class="btn btn--primary">Сохранить изменения</button>
                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn--secondary">Отмена</a>
            </div>
        </form>

        <!-- Форма удаления -->
        @can('delete', $article)
            <div class="form__danger-zone">
                <h3>Опасная зона</h3>
                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--danger">Удалить статью</button>
                </form>
            </div>
        @endcan
    </div>
</div>
@endsection