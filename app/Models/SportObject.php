<?php

namespace App\Models;

use App\Models\Advertisment\AdvertismentOrders;
use App\Models\Advertisment\RateAdvertisment;
use App\Models\Deal\Deal;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\ResponsesTenderAndTenders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SportObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sport_objects';
    protected $fillable = [
        'title',
        'objectType_id',
        'image',
        'description',
        'sportType_id',
        'accomodationConditionAndPricing_id',
        'city_id',
        'address',
        'postIndex',
        'longtitude',
        'latitude',
        'rating',
        'feedback_id',
        'user_id',
        'hasPromotion',
        'hasHighlightion',
        'hasVIP',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'objectType_id' => 'integer',
        'image' => 'array',
        'sportType_id' => 'integer',
        'accomodationConditionAndPricing_id' => 'integer',
        'city_id' => 'integer',
        'longtitude' => 'float',
        'latitude' => 'float',
        'rating' => 'float',
        'feedback_id' => 'array',
        'user_id' => 'integer',
        'hasPromotion' => 'boolean',
        'hasHighlightion' => 'boolean',
        'hasVIP' => 'boolean',
    ];

    public function scopeVerify($query)
    {
        return $query->where('verify', 1);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

    public function scopeWithSearch($query, $filters)
    {
        if ($filters->search && strlen((string)$filters->search) > 3) {
            $query->where(function ($query) use ($filters) {
                $query->where('title', 'like', "%$filters->search%")
                    ->orWhere('address', 'like', "%$filters->search%")
                    ->orWhere('description', 'like', "%$filters->search%");
            });
        }
    }

    public function scopeWithSportTypes($query, $filters)
    {
        if (empty($filters)) {
            return $query;
        }

        foreach ($filters as $filter) {
            $query->whereHas('sports', function ($query) use ($filter) {
                $query->where('sport_types.id', $filter);
            });
        }

        return $query;
    }

    public function scopeWithSort($query, $filters)
    {
        /*if ($filters->sort == null) return $query->orderBy('created_at', "desc");
        $type = explode(':', $filters->sort)[0];
        $direction = explode(':', $filters->sort)[1];

        return $query->when($type == 'new', function ($query) use ($direction) {
            $query->orderBy('created_at', $direction);
        })->when($type == 'minPrice', function ($query) use ($direction) {
            $query->orderBy('minPrice', $direction);
        })->when($type == "responses", function ($query) use ($direction) {
            $query->selectRaw('`tenders`.*, ((SELECT COUNT(`responses_tender_and_tenders`.`id`)
                FROM `responses_tender_and_tenders` WHERE `responses_tender_and_tenders`.`tender_id` = `tenders`.`id`)) AS `COUNT_RESPONSES`')
                ->orderBy('COUNT_RESPONSES', 'desc');
        });*/
    }

    public function scopeWithFilters($query, $filters)
    {
        if ($filters->search && strlen((string)$filters->search) > 2) {
            $query->where(function ($query) use ($filters) {
                $query->where('title', 'like', "%$filters->search%")
                    ->orWhere('address', 'like', "%$filters->search%")
                    ->orWhere('description', 'like', "%$filters->search%");
            });
        }

        $this->applySportTypeFilter($query, $filters->selectedSports_list ?? []);

        if ($filters->selectedRegions_list) {
            $regionIds = collect($filters->selectedRegions_list)->pluck('id');
            $query->whereHas('city.region', function ($query) use ($regionIds) {
                $query->whereIn('id', $regionIds);
            });
        }

        if ($filters->checkedFoods_list) {

        }

        if ($filters->checkedServices_list) {
            foreach ($filters->checkedServices_list as $service) {
                $query->whereHas('services', function ($subQuery) use ($service) {
                    $subQuery->where('service_id', $service['id']);
                });
            }
        }

        if ($filters->minPrice) {
            $pricing = $this->getPricing($query, (int)$filters->now_month - 1, (int)$filters->minPrice, null);
            $query->whereIn('id', $pricing);
        }

        if ($filters->maxPrice) {
            $pricing = $this->getPricing($query, (int)$filters->now_month - 1, null, (int)$filters->maxPrice);
            $query->whereIn('id', $pricing);
        }

        if ($filters->sort_sport) {
            $id = $filters->sort_sport['id'];
           // $query->orderBy('sports.title');
        }
    }

    protected function applySportTypeFilter($query, array $sportsList)
    {
        foreach ($sportsList as $sport) {
            $query->whereHas('sports', function ($subQuery) use ($sport) {
                $subQuery->where('sportType_id', $sport['id']);
            });
        }
    }

    public function getPricing($query, $now_month, $minPrice, $maxPrice)
    {
        $filterSportObjectsId = [];
        $sportObject = $query->whereHas('pricing')->with('pricing');
        foreach ($sportObject->get() as $item) {
            $sportObjectMinPrices = [];
            $sportObjectMaxPrices = [];
            foreach ($item->pricing as $pricing) {
                $pricing_res = [];
                foreach (json_decode($pricing['price']) as $price) $pricing_res[] = (array)$price;
                array_push($sportObjectMinPrices, (int)$pricing_res[$now_month]['minPrice']);
                array_push($sportObjectMaxPrices, (int)$pricing_res[$now_month]['maxPrice']);
            }
            if ($minPrice != null && min($sportObjectMinPrices) >= $minPrice) array_push($filterSportObjectsId, (int)$item['id']);
            else if ($maxPrice != null && max($sportObjectMinPrices) <= $maxPrice) array_push($filterSportObjectsId, (int)$item['id']);
        }
        return $filterSportObjectsId;
    }

    public function deals()
    {
        return $this->hasManyThrough(Deal::class, DirectApplications::class, 'sportObject_id', 'directApplication_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function objectType(): BelongsTo
    {
        return $this->belongsTo(ObjectType::class, 'objectType_id');
    }

    public function sportType(): BelongsTo
    {
        return $this->belongsTo(SportType::class, 'sportType_id');
    }

    public function sports(): BelongsToMany
    {
        return $this->belongsToMany(SportType::class, 'sport_type_and_objects', 'sportObject_id', 'sportType_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_and_objects', 'sportObject_id', 'service_id');
    }

    public function infrastructures(): BelongsToMany
    {
        return $this->belongsToMany(Infrastructure::class, 'infrastructure_and_objects',
            'sportObject_id', 'infrastructure_id');
    }

    public function accomodationConditionAndPricing(): BelongsTo
    {
        return $this->belongsTo(AccomodationConditionAndPricing::class, 'accomodationConditionAndPricing_id');
    }

    public function pricing(): BelongsToMany
    {
        return $this->belongsToMany(AccomodationTypeAndPricing::class, 'accomodation_type_and_pricing_and_objects',
            'sportObject_id', 'accomodationType_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(AdvertismentOrders::class, 'sportObject_id', 'id');
    }

    public function rate(): BelongsToMany
    {
        return $this->belongsToMany(RateAdvertisment::class, 'service_and_objects', 'sportObject_id', 'service_id');
    }

    public function directApplications()
    {
        return $this->hasMany(DirectApplications::class, 'sportObject_id');
    }

    public function responsesTender()
    {
        return $this->hasMany(ResponsesTender::class, 'sportObject_id');
    }
}
