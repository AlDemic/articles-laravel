<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'nick' => 'required|string|min:3|max:64|unique:users,nick',
            'email' => 'required|email:rfc|max:128|unique:users,email',
            'password' => 'required|string|min:4|max:32'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'nick' => trim($this->nick),
            'email' => trim($this->email),
            'password' => trim($this->password),
        ]);
    }
}
