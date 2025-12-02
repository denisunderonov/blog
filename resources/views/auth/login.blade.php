@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="auth-form">
    <h1 class="auth-form__title">Вход в систему</h1>

    @if(session('success'))
        <div class="alert alert--success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form__group">
            <label for="email" class="form__label">Email *</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form__input @error('email') form__input--error @enderror"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <span class="form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form__group">
            <label for="password" class="form__label">Пароль *</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form__input @error('password') form__input--error @enderror"
                required
            >
            @error('password')
                <span class="form__error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn--primary">Войти</button>

        <p class="auth-form__link">
            Нет аккаунта? <a href="{{ route('register.form') }}">Зарегистрироваться</a>
        </p>
    </form>
</div>
@endsection
