<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class InfoCompanyStoreRequest extends FormRequest
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
            'user_id' => ['required', 'integer'],
            'legal_name' => ['required', 'string'],
            'title' => ['required', 'string', 'max:100'],
            'tin' => ['required', 'string', 'max:100'],
            'numKpp' => ['required', 'string', 'max:100'],
            'bic' => ['required', 'string', 'max:100'],
            'requisites' => ['required', 'string', 'max:100'],
            'kc' => ['required', 'string', 'max:100'],
            'okpo' => ['required', 'string', 'max:100'],
            'okato' => ['required', 'string', 'max:100'],
            'orgn' => ['required', 'string', 'max:100'],
            'address_id' => ['required', 'integer'],
        ];
    }
}
