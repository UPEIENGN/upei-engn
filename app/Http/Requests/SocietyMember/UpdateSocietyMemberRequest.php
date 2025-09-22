<?php

namespace App\Http\Requests\SocietyMember;

use App\Models\SocietyMember;
use App\SocietyMemberRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSocietyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [SocietyMember::class, $this->society, $this->society_member]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('society_members')
                    ->ignore($this->society_member->id)
                    ->where(function ($query) {
                        return $query->where('society_id', $this->society->id);
                    }),
            ],
            'role' => ['sometimes', Rule::enum(SocietyMemberRole::class)],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
