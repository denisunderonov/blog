# Инструкция по установке шрифта Ditulum3

## Где скачать
Шрифт Ditulum3 можно скачать с:
- https://www.fontspace.com/ditulum3-font-f86729
- Google Fonts (если доступен)
- Или с официального источника автора

## Установка

1. Скачайте файлы шрифта в форматах:
   - Ditulum3.woff2
   - Ditulum3.woff
   - Ditulum3-Bold.woff2 (если есть)
   - Ditulum3-Bold.woff (если есть)

2. Поместите файлы в директорию:
   ```
   /Users/a1111/Desktop/blog/public/fonts/
   ```

3. После добавления файлов выполните:
   ```bash
   npm run build
   ```

## Альтернатива: Использовать Google Fonts или CDN

Если шрифт доступен через CDN, можно добавить в `resources/views/layouts/app.blade.php`:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Ditulum3&display=swap" rel="stylesheet">
```

Или использовать похожий шрифт с округлыми формами:
- Comfortaa
- Varela Round
- Quicksand
- Nunito
