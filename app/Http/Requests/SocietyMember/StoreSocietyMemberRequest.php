<?php

namespace App\Http\Requests\SocietyMember;

use App\Models\SocietyMember;
use Illuminate\Foundation\Http\FormRequest;

class StoreSocietyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', SocietyMember::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:society_members,email'],
            'role' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'renewed_at' => ['nullable', 'date'],
        ];
    }
}
