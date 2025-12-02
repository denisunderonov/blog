@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="auth-form">
    <h1 class="auth-form__title">Регистрация</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form__group">
            <label for="name" class="form__label">Имя *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form__input @error('name') form__input--error @enderror"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <span class="form__error">{{ $message }}</span>
            @enderror
        </div>

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

        <div class="form__group">
            <label for="password_confirmation" class="form__label">Подтверждение пароля *</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form__input"
                required
            >
        </div>

        <button type="submit" class="btn btn--primary">Зарегистрироваться</button>

        <p class="auth-form__link">
            Уже есть аккаунт? <a href="{{ route('login.form') }}">Войти</a>
        </p>
    </form>
</div>
@endsection
