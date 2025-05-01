<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string',
            'order_date' => 'required|date',
            'order_products' => 'array',
            'order_products.*.product_name' => 'required|string',
            'order_products.*.qty' => 'required|min:1',
            'order_products.*.price' => 'required|min:0',
        ];
    }
}
