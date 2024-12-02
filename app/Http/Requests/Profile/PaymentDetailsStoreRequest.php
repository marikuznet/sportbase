<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PaymentDetailsStoreRequest extends FormRequest
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
            'legal_name' => ['string'],
            'title' => ['string', 'max:100'],
            'tin' => ['string', 'max:100'],
            'numKpp' => ['string', 'max:100'],
            'bic' => ['string', 'max:100'],
            'requisites' => ['string', 'max:100'],
            'kc' => ['string', 'max:100'],
            'okpo' => ['string', 'max:100'],
            'okato' => ['string', 'max:100'],
            'orgn' => ['string', 'max:100'],
        ];
    }
}
