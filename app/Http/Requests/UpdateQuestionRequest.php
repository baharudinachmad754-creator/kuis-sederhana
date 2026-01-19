<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // controller also checks ownership; here only role guard
        return auth()->check() && auth()->user()->role === 'guru';
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'difficulty' => 'nullable|integer|min:1|max:5',
            'choices' => 'required|array|min:4|max:5',
            'choices.*.label' => 'required|in:a,b,c,d,e',
            'choices.*.choice_text' => 'required|string',
            'correct_label' => 'required|in:a,b,c,d,e',
        ];
    }
}
