# Используем официальный образ PHP 8.2 с FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Устанавливаем аргументы для пользователя
ARG user=laravel
ARG uid=1000

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем зависимости для PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем PHP расширения, необходимые для Laravel
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Устанавливаем Composer (менеджер пакетов для PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем системного пользователя для запуска Composer и Artisan команд
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем права доступа
RUN chown -R $user:www-data /var/www

# Переключаемся на созданного пользователя
USER $user
