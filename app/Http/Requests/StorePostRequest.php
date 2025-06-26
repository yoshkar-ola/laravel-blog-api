<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь делать этот запрос.
     */
    public function authorize(): bool
    {
        // Если нужно разрешить только авторизованным — true.
        // Дополнительно можно проверять права, но для простоты:
        return auth()->check();
    }

    /**
     * Правила валидации для запроса.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'text'  => 'required|string',
        ];
    }

    /**
     * (Опционально) Сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен к заполнению',
            'title.max'      => 'Максимальная длина заголовка — 255 символов',
            'text.required'  => 'Текст публикации не может быть пустым',
        ];
    }
}
