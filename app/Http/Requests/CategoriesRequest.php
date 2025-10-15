<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'category_name' => 'required|string|max:250',
            'note' => 'required|string|min:5|max:250',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_name.required' => 'اسم الفئة مطلوب',
            'category_name.string' => 'يجب أن يكون اسم الفئة مكونًا من حروف',
            'category_name.max' => 'يجب ألا يزيد اسم الفئة عن 250 حرفًا',

            'note.required' => 'الوصف مطلوب',
            'note.string' => 'يجب أن يكون الوصف نصًا فقط',
            'note.min' => 'يجب ألا يقل الوصف عن 5 أحرف',
            'note.max' => 'يجب ألا يزيد الوصف عن 250 حرفًا',
        ];
    }
}
