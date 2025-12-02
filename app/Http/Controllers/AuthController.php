<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== РЕГИСТРАЦИЯ =====
    
    /**
     * Показать форму регистрации
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Обработать регистрацию нового пользователя
     */
    public function register(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // confirmed проверяет password_confirmation
        ], [
            'name.required' => 'Имя обязательно для заполнения',
            'email.required' => 'Email обязателен для заполнения',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Пользователь с таким email уже существует',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.min' => 'Пароль должен быть минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Хешируем пароль
        ]);

        // Редирект на форму авторизации с сообщением
        return redirect()
            ->route('login.form')
            ->with('success', 'Регистрация прошла успешно! Войдите в систему.');
    }

    // ===== АВТОРИЗАЦИЯ =====
    
    /**
     * Показать форму авторизации
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Обработать вход пользователя
     */
    public function login(Request $request)
    {
        // Валидация входных данных
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Пароль обязателен',
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            // Регенерация сессии для безопасности
            $request->session()->regenerate();

            // Создание токена Sanctum для пользователя
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            // Сохраняем токен в сессии (опционально, для веб-приложения)
            session(['auth_token' => $token]);

            // Редирект на главную страницу
            return redirect()
                ->intended(route('home'))
                ->with('success', 'Добро пожаловать, ' . $user->name . '!');
        }

        // Если аутентификация не удалась
        return back()
            ->withErrors([
                'email' => 'Неверный email или пароль.',
            ])
            ->onlyInput('email');
    }

    // ===== ВЫХОД =====
    
    /**
     * Выход пользователя из системы
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Удаление всех токенов пользователя
        if ($user) {
            $user->tokens()->delete();
        }

        // Выход из системы
        Auth::logout();

        // Аннулирование сессии
        $request->session()->invalidate();

        // Регенерация CSRF токена
        $request->session()->regenerateToken();

        // Редирект на главную страницу
        return redirect()
            ->route('home')
            ->with('success', 'Вы успешно вышли из системы');
    }
}