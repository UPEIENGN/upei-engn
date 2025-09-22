<?php

namespace App\Http\Requests\SocietyMember;

use App\Models\SocietyMember;
use App\SocietyMemberRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocietyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', [SocietyMember::class, $this->society]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('society_members')->where(fn ($query) => $query->where('society_id', $this->society->id))
            ],
            'role' => ['required', Rule::enum(SocietyMemberRole::class)],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'paid_membership' => ['required', 'boolean'],
        ];
    }
}
