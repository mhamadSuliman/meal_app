<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
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
             'name'=>'string|max:255|nullable',
            'description'=>'string|min:20|nullable',
            'rating'=>'numeric|nullable|max:5|nullable',
            'price'=>'numeric|nullable|required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type'=>'string|nullable',
        ];
    }
}
