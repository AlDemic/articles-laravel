<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
     return [
            'title' => 'required|string|min:3|max:24|unique:categories,title',
            'url' => 'required|string|unique:categories,url'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'title' => trim($this->title),
            'url' => Str::slug($this->title)
        ]);
    }
}
