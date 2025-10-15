<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:5|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = [
                'category_id' => 'sometimes|exists:categories,id',
                'title' => 'sometimes|string|min:5|max:255',
                'summary' => 'nullable|string|max:500',
                'content' => 'sometimes|string',
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'user_id.required' => 'الكاتب مطلوب',
            'category_id.required' => 'القسم مطلوب',
            'category_id.exists' => 'القسم غير موجود',
            'title.required' => 'العنوان مطلوب',
            'title.min' => 'يجب ألا يقل العنوان عن 5 أحرف',
            'title.max' => 'يجب ألا يزيد العنوان عن 255 حرفًا',
            'content.required' => 'المحتوى مطلوب',
            'content.string' => 'يجب أن يكون المحتوى نصًا',
            'summary.max' => 'يجب ألا يزيد الملخص عن 500 حرف',
        ];
    }
}
