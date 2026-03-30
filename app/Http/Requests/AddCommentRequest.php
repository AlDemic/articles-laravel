<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddCommentRequest extends FormRequest
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
            'msg' => ['required', 'string', 'min:3', 'max:1024',
                            Rule::unique('comments', 'msg')->where('user_id', Auth::id())
                                                           ->where('article_id', $this->route('article')->id)
            ]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'msg' => trim($this->msg)
        ]);
    }
}
