<?php

namespace App\Http\Requests\Society;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocietyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->society);
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
            'description' => ['nullable', 'string'],
            'email' => ['sometimes', 'email'],

            'facebook_url' => ['nullable', 'url'],
            'instagram_handle' => ['nullable', 'string'],
            'twitter_handle' => ['nullable', 'string'],
            'discord_url' => ['nullable', 'url'],

            'meeting_schedule' => ['nullable', 'string'],
            'meeting_location' => ['nullable', 'string'],
        ];
    }
}
