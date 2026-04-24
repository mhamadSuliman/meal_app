<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'=>'string|required|max:255',
            'description'=>'string|required|min:20',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type'=>'required|string',
            'addons' => 'nullable|array',             // تتحقق إذا أرسل إضافات
            'addons.*' => 'exists:addons,id'         // كل ID موجود في جدول الإضافات
        ];
        
    }
}
