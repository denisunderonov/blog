<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('article');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $articleId,
            'content' => 'required|string|min:10',
            'image' => 'nullable|url|max:500',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.max' => 'Заголовок не должен превышать 255 символов',
            'slug.required' => 'Slug обязателен для заполнения',
            'slug.unique' => 'Статья с таким slug уже существует',
            'content.required' => 'Содержание статьи обязательно',
            'content.min' => 'Содержание должно быть не менее 10 символов',
            'image.url' => 'Изображение должно быть валидным URL',
            'published_at.date' => 'Дата публикации должна быть валидной',
        ];
    }
}
