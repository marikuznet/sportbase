<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccomodationConditionAndPricingUpdateRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'includedInAccomodationPricing_id' => ['required', 'integer', 'exists:includedInAccomodationPricings,id'],
            'image' => ['required', 'json'],
            'accomodationTypeAndPricing_id' => ['required', 'integer', 'exists:accomodationTypeAndPricings,id'],
        ];
    }
}
