@extends('layouts.app')

@section('title', 'Редактировать комментарий')

@section('content')
<div class="container">
    <div class="form-wrapper">
        <h1 class="form-title">Редактировать комментарий</h1>

        <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="comment-form__form">
            @csrf
            @method('PUT')

            <div class="form__group">
                <label for="content" class="form__label">Комментарий *</label>
                <textarea 
                    id="content" 
                    name="content" 
                    class="form__textarea @error('content') form__input--error @enderror"
                    rows="6"
                    required
                >{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__actions">
                <button type="submit" class="btn btn--primary">Сохранить изменения</button>
                <a href="{{ route('articles.show', $comment->article->slug) }}" class="btn btn--secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection
