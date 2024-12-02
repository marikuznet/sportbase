<?php

namespace App\Models;

use App\Models\Deal\Deal;
use App\Models\Profile\InfoCompany;
use App\Models\Tender\AdditionTender;
use App\Models\Tender\RequirementInfrastructures;
use App\Models\Tender\TypeFood;
use App\Traits\HasLocalDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class DirectApplications extends Model
{
    const STATUS_NEW = 0;
    const STATUS_DEAL = 1;
    const STATUS_REJECTED_CUSTOMER = 2;
    const STATUS_REJECTED_EXECUTOR = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_COMPLETE_ARBITER = 5;
    use HasFactory, HasLocalDates;

    protected $fillable = [
        'infoCompany_id', 'sportObject_id', 'city_id', 'startDate', 'endDate',
        'spreadDate', 'colPeople', 'priceForPerson', 'minPrice',
        'createDate', 'user_id', 'comment', 'archive', 'feedback', 'rating'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'infoCompany_id' => 'integer',
        'sportObject_id' => 'integer',
        'city_id' => 'integer',
        'createDate' => 'date',
        'user_id' => 'integer',
        'startDate' => 'date',
        'endDate' => 'date',
        'colPeople' => 'integer',
        'priceForPerson' => 'float',
        'archive' => 'integer',
        'minPrice' => 'float',
        'feedback' => 'array',
        'rating' => 'double'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sportObject(): BelongsTo
    {
        return $this->belongsTo(SportObject::class, 'sportObject_id');
    }

    public function infoCompany(): BelongsTo
    {
        return $this->belongsTo(InfoCompany::class, 'infoCompany_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'id', 'directApplication_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'directApplication_id');
    }

    public function additions(): BelongsToMany
    {
        return $this->belongsToMany(AdditionTender::class, 'direct_applications_and_additions', 'directApplication_id', 'additionTender_id');
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(TypeFood::class, 'direct_applications_and_type_foods', 'directApplication_id', 'typeFood_id');
    }

    public function sports(): BelongsToMany
    {
        return $this->belongsToMany(SportType::class, 'direct_applications_and_type_sports', 'directApplication_id', 'sportType_id');
    }

    public function infrastructures(): BelongsToMany
    {
        return $this->belongsToMany(RequirementInfrastructures::class, 'direct_applications_and_infrastructures', 'directApplication_id', 'infrastructure_id');
    }

    public function scopeHasUser($query)
    {
        if (Auth::user()->role === User::USER_ROLE_EXECUTOR) {
            $query->with(['sportObject'])
                ->whereHas('sportObject', function ($query) {
                    $query->where('user_id', '=', Auth::id());
                });
        }
        if (Auth::user()->role === User::USER_ROLE_CUSTOMER) {
            $query->where('user_id', Auth::id());
        }
    }

    public function scopeActive($query)
    {
        $query->whereIn('archive', [DirectApplications::STATUS_NEW, DirectApplications::STATUS_DEAL])->whereDate('startDate', '>', now());
    }

    public function scopeArchive($query)
    {
        $query->whereIn('archive', [DirectApplications::STATUS_REJECTED_CUSTOMER,
            DirectApplications::STATUS_REJECTED_EXECUTOR,
            DirectApplications::STATUS_COMPLETE,
            DirectApplications::STATUS_COMPLETE_ARBITER]);
    }

    public function scopeWithFiltersToProfile($query, $filter)
    {
        $query->when($filter->minPrice, function ($query) use ($filter) {
            $query->where('minPrice', '>=', $filter->minPrice);
        })
            ->when($filter->maxPrice, function ($query) use ($filter) {
                $query->where('maxPrice', '<=', $filter->maxPrice);
            })
            ->when($filter->start_date, function ($query) use ($filter) {
                $query->where('fullStartDate', '>=', $filter->start_date);
            })
            ->when($filter->end_date, function ($query) use ($filter) {
                $query->where('fullEndDate', '<=', $filter->end_date);
            })
            ->when($filter->foods, function ($query) use ($filter) {
                foreach ($filter->foods as $food) {
                    $query->whereHas('foods', function ($subQuery) use ($food) {
                        $subQuery->where('typeFood_id', $food['id']);
                    });
                }
            })
            ->when($filter->services, function ($query) use ($filter) {
                foreach ($filter->services as $service) {
                    $query->whereHas('additions', function ($subQuery) use ($service) {
                        $subQuery->where('additionTender_id', $service['id']);
                    });
                }
            })
            ->when($filter->infrastructures, function ($query) use ($filter) {
                // TODO:сделать
            });

        return $query;
    }
}
