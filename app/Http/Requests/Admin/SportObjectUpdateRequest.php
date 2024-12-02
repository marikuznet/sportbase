<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SportObjectUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'objectType_id' => ['required', 'integer', 'exists:objectTypes,id'],
            'image' => ['required', 'json'],
            'description' => ['required', 'string'],
            'sportType_id' => ['required', 'integer', 'exists:sportTypes,id'],
            'accomodationConditionAndPricing_id' => ['required', 'integer', 'exists:accomodationConditionAndPricings,id'],
            'infrastructure_id' => ['required', 'integer', 'exists:infrastructures,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:100'],
            'postIndex' => ['required', 'integer'],
            'longtitude' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric'],
            'rating' => ['required', 'numeric'],
            'feedback_id' => ['required', 'json'],
            'user_id' => ['required', 'integer'],
            'hasPromotion' => ['required'],
            'hasHighlightion' => ['required'],
            'hasVIP' => ['required'],
        ];
    }
}
