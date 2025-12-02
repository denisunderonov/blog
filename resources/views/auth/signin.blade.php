@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container">
    <div class="auth-form">
        <h1 class="auth-form__title">Регистрация</h1>
        
        <form action="{{ route('auth.registration') }}" method="POST" class="form">
            @csrf
            
            <div class="form__group">
                <label for="name" class="form__label">Имя</label>
                <input type="text" id="name" name="name" class="form__input" value="{{ old('name') }}" required>
                @error('name')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="email" class="form__label">Email</label>
                <input type="email" id="email" name="email" class="form__input" value="{{ old('email') }}" required>
                @error('email')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label for="password" class="form__label">Пароль</label>
                <input type="password" id="password" name="password" class="form__input" required>
                @error('password')
                    <span class="form__error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn--primary">Зарегистрироваться</button>
        </form>
    </div>
</div>
@endsection
