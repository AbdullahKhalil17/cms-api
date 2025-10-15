<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommetsRequest extends FormRequest
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
            'news_id' => 'required|exists:news,id',
            'comment' => 'required|string|min:1|max:1000',
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
            'news_id.required' => 'الخبر مطلوب',
            'news_id.exists' => 'الخبر غير موجود',
            'comment.required' => 'التعليق مطلوب',
            'comment.min' => 'يجب ألا يقل التعليق عن حرف واحد',
            'comment.max' => 'يجب ألا يزيد التعليق عن 1000 حرف',
        ];
    }
}
