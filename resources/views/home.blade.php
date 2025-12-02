@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="container">
    <div class="home-hero">
        <h1 class="home-hero__title">Добро пожаловать</h1>
        <p class="home-hero__subtitle">Начните свое путешествие</p>
        <a href="{{ route('auth.signin') }}" class="btn btn--primary">Зарегистрироваться</a>
    </div>
</div>
@endsection
