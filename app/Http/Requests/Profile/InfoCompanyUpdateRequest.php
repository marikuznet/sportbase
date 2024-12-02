<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class InfoCompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => [ 'string'],
            'title' => [ 'string', 'max:100'],
            'phoneCompany' => [ 'json'],
            'quantityEmployees' => [ 'string'],
            'emailCompany' => [ 'string'],
            'site' => [ 'string'],
            'description' => [ 'string', 'max:2000'],
            'address_id' => [ 'integer', 'exists:addresses,id'],

            'facebook' => [ 'string'],
            'twitter' => [ 'string'],
            'linkedIn' => [ 'string'],
            'telegram' => [ 'string'],
            'slack' => [ 'string'],
            'instagram' => [ 'string'],

            'surname' => [ 'string'],
            'name' => [ 'string'],
            'patronymic' => [ 'string'],
            'position_id' => [ 'integer', 'exists:positions,id'],
            'email' => [ 'string'],
            'phone' => [ 'string'],
        ];
    }
}
