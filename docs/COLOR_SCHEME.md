# Цветовая схема блога

## Основные цвета

### Cherry Cola (#9A0002)
- **RGB**: rgb(154, 0, 2)
- **Использование**: Header, Footer, заголовки
- **Ассоциации**: Элегантность, классика, энергия

### Cream Vanilla (#EFE6DE)
- **RGB**: rgb(239, 230, 222)
- **Использование**: Основной фон, текст на темном фоне
- **Ассоциации**: Уют, мягкость, читаемость

### Золотой / Gold (#D4AF37)
- **RGB**: rgb(212, 175, 55)
- **Использование**: CTA кнопки, акценты
- **Ассоциации**: Премиальность, важность, действие
- **Hover**: #B8941F (более темный золотой)

## Дополнительные цвета

### Темный текст (#2C1810)
- **Использование**: Основной текст на светлом фоне

### Светлый текст (#5A4A42)
- **Использование**: Вторичный текст, описания

## Сочетания

✅ **Хорошо работают вместе:**
- Cherry Cola + Cream Vanilla (высокий контраст)
- Gold + Cherry Cola (теплые оттенки)
- Cream Vanilla + Dark Text (отличная читаемость)

⚠️ **Использовать осторожно:**
- Gold + Cream Vanilla (низкий контраст, только для акцентов)

## Применение

```scss
// Header & Footer
background: #9A0002 (Cherry Cola)
text: #EFE6DE (Cream Vanilla)

// Main Content
background: #EFE6DE (Cream Vanilla)
text: #2C1810 (Dark Text)

// Buttons (Primary CTA)
background: #D4AF37 (Gold)
text: #2C1810 (Dark Text)
hover: #B8941F (Darker Gold)

// Cards
background: #FFFFFF (White)
border/shadow: rgba(0,0,0,0.1)
```

## Accessibility

Все цветовые сочетания проверены на контрастность:
- Cherry Cola на Cream Vanilla: ✅ AAA
- Dark Text на Cream Vanilla: ✅ AA
- Gold на Dark: ✅ AA
