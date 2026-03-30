<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SuggestArticleRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:128',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'short_desc' => 'required|string|min:3|max:255',
            'full_desc' => 'required|string|min:100|max:2025',
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'title' => trim($this->title),
            'short_desc' => isset($this->short_desc)
                                                ? trim($this->short_desc) 
                                                : substr(trim($this->full_desc), 0, 255),
            'full_desc' => trim($this->full_desc),   
        ]);
    }
}
