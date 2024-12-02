<?php

namespace App\Filters;

use App\Models\Tender\Tender;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Token\Builder;

class TendersFilter extends QueryFilter
{
    public function sports($id)
    {
        return $this->builder->where("type_sports", "like", "%id%:$id,%")->get();
    }

    public function region($id)
    {

        $tenders = $this->builder->whereHas('city', function($query) use ($id) {
            return $query->whereHas('region', function ($q) use ($id) {
                return $q->where('id', '=', $id);
            });
        });
        return $tenders;
    }

    public function col($colPeople)
    {
        return $this->builder->where('colPeople', '<', $colPeople);
    }

    public function price($price)
    {
        return $this->builder->where('priceForPerson', '<', $price);
    }

    public function dateStart($startDate)
    {
        return $this->builder->whereDate('startDate', '>=', $startDate);
    }

    public function dateEnd($endDate)
    {
        return $this->builder->whereDate('endDate', '<=', $endDate);
    }

    public function searchField($searchField)
    {
        return $this->builder->with(["user"])->where('comment', 'like', "%$searchField%");
    }

    public function sort($sort)
    {
        $type = explode(':', $sort)[0];
        $direction = explode(':', $sort)[1];
        $query = null;
        switch ($type){
            case 'new': {
                $query = $this->builder->orderBy('created_at', $direction);
            }
            case 'minPrice': {
                $query = $this->builder->orderBy('minPrice', $direction);
            }
            case 'responses': {
                $query = $this->builder->selectRaw('`tenders`.*, ((SELECT COUNT(`responses_tender_and_tenders`.`id`)
                FROM `responses_tender_and_tenders` WHERE `responses_tender_and_tenders`.`tender_id` = `tenders`.`id`)) AS `COUNT_RESPONSES`')
                ->orderBy('COUNT_RESPONSES', 'desc');
            }
            default: {
                $query = $this->builder->orderBy('created_at');
            }
        }
        return $query;
    }

    public function responses($responses)
    {
       /* return $this->builder->selectRaw('`responses_tenders`.*, ((SELECT COUNT(`responses_tender_and_tenders`.`id`)
                FROM `responses_tender_and_tenders` WHERE `responses_tender_and_tenders`.`responsesTender_id`
                = `responses_tenders`.`id`)) AS `COUNT_RESPONSES`')
            ->orderBy('COUNT_RESPONSES', 'desc');*/
    }

    public function requests($requests)
    {
        return $this->builder->where('user_id', '=', Auth::id());
    }
}
