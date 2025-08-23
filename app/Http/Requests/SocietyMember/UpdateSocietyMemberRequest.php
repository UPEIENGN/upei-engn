<?php

namespace App\Http\Requests\SocietyMember;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocietyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->society_member);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['sometimes', 'email', "unique:society_members,email"],
            'role' => ['sometimes', 'integer'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'renewed_at' => ['nullable', 'date'],
        ];
    }
}
