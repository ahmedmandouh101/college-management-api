<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|unique:courses',
            'department_id' => 'required|exists:departments,id',
            'teacher_id'    => 'required|exists:users,id',
            'credits'       => 'required|integer|min:1|max:6'
        ];
    }
}