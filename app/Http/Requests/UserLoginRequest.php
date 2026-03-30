<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc|max:128|exists:users,email',
            'password' => 'required|string|min:4|max:32'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'email' => trim($this->email),
            'password' => trim($this->password),
        ]);
    }
}
