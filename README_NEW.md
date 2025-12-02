# MyBlog - Laravel блог с Docker

Современный блог на Laravel 12 с PostgreSQL, Redis, Nginx и красивым дизайном.

## 🎨 Дизайн

Цветовая схема:
- **Cherry Cola** (#9A0002) - Header и Footer
- **Cream Vanilla** (#EFE6DE) - Основной фон
- **Золотой** (#D4AF37) - CTA кнопки

## 🚀 Технологии

- **Backend**: Laravel 12, PHP 8.2
- **Database**: PostgreSQL 16
- **Cache**: Redis
- **Web Server**: Nginx
- **Frontend**: Vite, SCSS
- **Container**: Docker, Docker Compose

## 📦 Установка

### Требования
- Docker & Docker Compose
- Node.js 18+ (для фронтенда)

### Шаги установки

1. **Клонировать репозиторий**
```bash
git clone <repository-url>
cd blog
```

2. **Запустить Docker контейнеры**
```bash
docker-compose up -d
```

3. **Установить зависимости Node.js**
```bash
npm install
```

4. **Скомпилировать фронтенд**
```bash
npm run build
# или для разработки с горячей перезагрузкой:
npm run dev
```

5. **Настроить права доступа**
```bash
chmod -R 775 storage bootstrap/cache
```

6. **Запустить миграции**
```bash
docker-compose exec app php artisan migrate
```

## 🌐 Доступ

- **Приложение**: http://localhost:8000
- **Vite Dev Server**: http://localhost:5173
- **PostgreSQL**: localhost:5432
- **Redis**: localhost:6379

## 🛠 Разработка

### Полезные команды

```bash
# Остановить контейнеры
docker-compose down

# Просмотреть логи
docker-compose logs -f

# Войти в контейнер приложения
docker-compose exec app bash

# Выполнить Artisan команды
docker-compose exec app php artisan [команда]

# Установить пакеты Composer
docker-compose exec app composer require [пакет]

# Подключиться к PostgreSQL
docker-compose exec db psql -U laravel -d laravel

# Компиляция SCSS
npm run build          # Production сборка
npm run dev            # Development с hot reload
```

### Структура SCSS

```
resources/scss/
├── app.scss           # Главный файл
├── _variables.scss    # Переменные (цвета, размеры)
├── _reset.scss        # Сброс стилей
├── _header.scss       # Стили header
├── _footer.scss       # Стили footer
└── _components.scss   # Компоненты (кнопки, карточки)
```

## 📝 Создание контента

### Добавление постов

Посты можно добавлять через:
1. Админ-панель (в разработке)
2. Прямо в базу данных
3. Через API (в разработке)

## 🔒 Переменные окружения

Основные настройки в `.env`:

```env
APP_NAME=MyBlog
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379
```

## 📄 Лицензия

MIT License

## 👨‍💻 Автор

Создано с ❤️
