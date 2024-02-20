<?php

namespace App\Http\Requests\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'userType' => ['required'],
            'otp' => ['nullable'],
            'image' => ['nullable'],
            'phoneNo' => ['nullable', 'unique:'.User::class.',phone_number'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_type' => $this->userType,
            'phone_no' => $this->phoneNo,
        ]);
    }
}
