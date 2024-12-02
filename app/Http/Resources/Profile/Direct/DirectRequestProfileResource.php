<?php

namespace App\Http\Resources\Profile\Direct;

use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\SportObjectResource;
use App\Models\SportObject;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectRequestProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $sport_object = new SportObjectResource($this->sportObject);
        $info_executor = $this->when($this->sportObject->user->infoCompany, new InfoCompanyResource($this->sportObject->user->infoCompany));
        if ($this->user->infoCompany) {
            $infoCompany = $this->user->infoCompany;
            $phoneCompany = $infoCompany->phoneCompany !== "[]" ? json_decode($infoCompany->phoneCompany)[0] : "";
            $title_company = $infoCompany->typePerson === 0 ? $infoCompany->title : $infoCompany->name . ' ' . $infoCompany->surname;
            $phone_company = $infoCompany->typePerson === 0 ? $phoneCompany : json_decode($infoCompany->phone);
            $email_company = $infoCompany->typePerson === 0 ? $infoCompany->emailCompany : $infoCompany->email;
            $image_company = json_decode($infoCompany->image);
        }

        return [
            'id' => $this->id,
            'city' => $sport_object->city->title,
            'sportObject' => [
                'id' => $sport_object->id,
                'title' => $sport_object->title,
                'country' => $sport_object->country,
                'city' => $sport_object->city->title,
                'address' => $sport_object->address,
                'user_id' => $sport_object->user_id,
                'minPrice' => $this->minPrice(),
                'average_rating' => $sport_object->reviewsAverageRating() ?? 0,
                'reviews_count' => $sport_object->getReviewsCount() ?? 0,
            ],
            'customer_info' => [
                'user_id' => $this->user_id ?? '',
                'title' => $title_company ?? '',
                'email' => $email_company ?? '',
                'phone' => $phone_company ?? '',
                'logo' => $image_company ?? '',
            ],
            'executor_info' => [
                'user_id' => $info_executor->user_id ?? '',
                'title' => $info_executor->typePerson == 0 ? $info_executor->title :
                    $info_executor->surname + ' ' + $info_executor->name,
                'logo' => json_decode($info_executor->image) ?? ''
            ],
            'createDate_month' => Carbon::parse($this->created_at)->translatedFormat('d F'),
            'createDate_time' => Carbon::parse($this->created_at)->translatedFormat('H:i'),

            'type_sports' => $this->when($this->sports, $this->sports->map(function ($sport) {
                return [
                    'id' => $sport->id,
                    'title' => $sport->title,
                ];
            }), null),
            'typeFoods' => $this->when($this->foods, $this->foods->map(function ($food) {
                return [
                    'id' => $food->id,
                    'title' => $food->title,
                ];
            }), null),
            'additions' => $this->additions->map(function ($addition) {
                return [
                    'id' => $addition->id,
                    'title' => $addition->title,
                ];
            }),
            'additionsTender' => $this->additions->map(function ($addition) {
                return [
                    'id' => $addition->id,
                    'title' => $addition->title,
                ];
            }),
            'infrastructures' => $this->infrastructures ? $this->infrastructures->map(function ($infrastructure) {
                return [
                    'id' => $infrastructure->id,
                    'title' => $infrastructure->title,
                ];
            }) : null,
            'colPeople' => $this->colPeople,
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'archive' => $this->archive,
            'deal' => $this->deal ? true : false,
            'dealData' => (bool)$this->deal ? [
                'rejection' => (bool)$this->deal->rejectionsDeal !== null ? true : false,
                'status' => $this->deal->status,
                'step' => $this->deal->step,
                'complete' => $this->deal->complete,
                'accept_by_customer' => $this->deal->accept_by_customer,
                'accept_by_executor' => $this->deal->accept_by_executor
            ] : null,
            'deal_id' => $this->when($this->deal, function () {
                return $this->deal['id'];
            }),
            'fullStartDate' =>  Carbon::parse($this->startDate)->translatedFormat('Y-m-d'),
            'fullEndDate' => Carbon::parse($this->endDate)->translatedFormat('Y-m-d'),

            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d'),
            'startDate_day' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F Y'),
            'spreadDate' => $this->spreadDate,
            'comment' => $this->comment
        ];
    }

    private function minPrice()
    {
        $minPrices = collect($this->sportObject->pricing)
            ->pluck('price')
            ->map(function ($price) {
                $price = json_decode($price, true);
                $month = Carbon::now()->month - 1;
                return isset($price[$month]['minPrice']) ? (int)$price[$month]['minPrice'] : null;
            })
            ->filter()
            ->all();

        return count($minPrices) > 0 ? min($minPrices) : 0;
    }
}
