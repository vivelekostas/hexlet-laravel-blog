<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Берёт на себя функцию валидации, позволяя убрать её из методов контроллера,
 * т.е позволяет избежать дублирования кода.
 * Class ArticleValidateRequest
 * @package App\Http\Requests
 */
class ArticleValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Выставленно true, так как нет никаких юзеров у меня пока,
     * а изначально было false.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:articles',
            'body' => 'required|min:10',
        ];
    }
}
