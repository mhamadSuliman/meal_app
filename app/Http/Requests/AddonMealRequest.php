<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddonMealRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'price'=>'nullable|numeric',
            'price' => 'required|numeric|min:0',
            'is_active'=>'boolean',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'addons' => 'array',
            'addons.*' => 'exists:addons,id'
        ];
    }
    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $restaurant_id = $this->route('restaurant_id');

        $invalid = \App\Models\Addon::whereIn('id', $this->addons ?? [])
            ->where('restaurant_id', '!=', $restaurant_id)
            ->exists();

        if ($invalid) {
            $validator->errors()->add('addons', 'بعض الإضافات لا تنتمي لهذا المطعم');
        }
    });
}
}
