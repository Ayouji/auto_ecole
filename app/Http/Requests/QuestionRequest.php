<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'questionnaire_id' => 'required|exists:questionnaires,id',
            'text' => 'required|string|max:255',
            'type' => 'required',
            'category_id' => 'required',
            'new_category' => 'nullable|string|max:255',
            'choices' => 'required_if:type,qcm|array',
            'choices.*' => 'required_if:type,qcm|string|max:255',
            // 'is_calculated' => 'nullable|boolean',
        ];
    }
}
