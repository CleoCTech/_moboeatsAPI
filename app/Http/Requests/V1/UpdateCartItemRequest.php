<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'cartId' => ['required'],
                'menuId' => ['required'],
                'quantity' => ['required'],
                'status' => ['nullable', 'integer'],
            ];
        } else {
            return [
                'cartId' => ['sometimes','required'],
                'menuId' => ['sometimes','required'],
                'quantity' => ['sometimes','required'],
                'status' => ['sometimes','required'],
            ];
        }
    }
    protected function prepareForValidation()
    { 
        if ($this->cartId) {
            $this->merge([
                'cart_id' => $this->cartId,
            ]);
        }
        if ($this->menuId) {
            $this->merge([
                'menu_id' => $this->menuId,
            ]);
        }
        
    }
}
