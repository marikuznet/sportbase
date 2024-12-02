<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SportObjectStoreRequest extends FormRequest
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
            'objectType_id' => ['required', 'integer'],
            'image' => ['required', 'json'],
            'description' => ['required', 'string'],
            'sportType_id' => ['required', 'integer'],
            'accomodationConditionAndPricing_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:100'],
            'postIndex' => ['required', 'integer'],
            //'longtitude' => ['required', 'numeric'],
            //'latitude' => ['required', 'numeric'],
            //'rating' => ['numeric'],
            //'feedback_id' => [ 'json'],
            'user_id' => ['required', 'integer'],
            //'hasPromotion' => [],
           // 'hasHighlightion' => ['required'],
           //'hasVIP' => ['required'],
        ];
    }
}
