<?php

namespace App\Models\Tender;

use App\Models\City;
use App\Models\Deal\Deal;
use App\Models\Profile\InfoCompany;
use App\Models\SportObject;
use App\Models\SportType;
use App\Models\User;
use App\Traits\HasLocalDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class ResponsesTender extends Model
{
    use HasFactory;
    use HasLocalDates;

    const STATUS_NEW = 0;
    const STATUS_DEAL = 1;
    const STATUS_REJECTED_CUSTOMER = 2;
    const STATUS_REJECTED_EXECUTOR = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $table = "responses_tenders";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id', 'infoCompany_id', 'sportObject_id', 'city_id', 'startDate', 'endDate',
        'spreadDate', 'colPeople', 'priceForPerson', 'minPrice',
        'createDate', 'comment', 'archive', 'dateResponse'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'infoCompany_id' => 'integer',
        'sportObject_id' => 'integer',
        'city_id' => 'integer',
        'createDate' => 'date',
        'startDate' => 'date',
        'endDate' => 'date',
        'colPeople' => 'integer',
        'priceForPerson' => 'float',
        'minPrice' => 'float',
        'archive' => 'integer',
        'dateResponse' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function infoCompany(): BelongsTo
    {
        return $this->belongsTo(InfoCompany::class, 'infoCompany_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function sportObject(): BelongsTo
    {
        return $this->belongsTo(SportObject::class, 'sportObject_id');
    }

    public function tender()
    {
        return $this->belongsToMany(Tender::class, 'responses_tender_and_tenders',
            'responsesTender_id', 'tender_id');
    }

    public function tenders()
    {
        return $this->belongsToMany(Tender::class, 'responses_tender_and_tenders', 'responsesTender_id', 'tender_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'responsesTender_id', 'id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'id', 'responsesTender_id');
    }

    public function additions(): BelongsToMany
    {
        return $this->belongsToMany(AdditionTender::class, 'responses_tenders_and_additions', 'responsesTender_id', 'additionTender_id');
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(TypeFood::class, 'responses_tenders_and_type_foods', 'responsesTender_id', 'typeFood_id');
    }

    public function sports(): BelongsToMany
    {
        return $this->belongsToMany(SportType::class, 'responses_tenders_and_type_sports', 'responsesTender_id', 'sportType_id');
    }

    public function infrastructures(): BelongsToMany
    {
        return $this->belongsToMany(RequirementInfrastructures::class, 'responses_tenders_and_infrastructures', 'responsesTender_id', 'infrastructure_id');
    }

    public function scopeHasUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function scopeArchive($query)
    {
        return $query->whereIn('archive', [
            ResponsesTender::STATUS_REJECTED_CUSTOMER,
            ResponsesTender::STATUS_REJECTED_EXECUTOR,
        ])->orWhere(function ($query) {
            $query->where('archive', ResponsesTender::STATUS_NEW)
                ->whereDate('startDate', '<', now());
        });
    }

    public function scopeActive($query)
    {
        return $query->whereIn('archive', [
            ResponsesTender::STATUS_DEAL,
            ResponsesTender::STATUS_NEW
        ])->where(function ($query) {
            $query->whereIn('archive', [ResponsesTender::STATUS_DEAL, ResponsesTender::STATUS_NEW])
                ->whereDate('startDate', '>', now())
                ->where(function ($query) {
                    $query->whereHas('deal', function ($q) {
                        $q->where('step', '<', 2);
                    })->orWhere(function ($query) {
                        $query->doesntHave('deal');
                    });
                });
        });
    }

    public function scopeWithFiltersToResponsesTender($query, $filters)
    {
        if ($filters->search) {
            $query->where(function ($query) use ($filters) {
                $query->where('comment', 'like', "%$filters->search%")
                    ->orWhere('id', 'like', "%$filters->search%");
            });
        }

        if ($filters->minPrice != 0) {
            $query->where('minPrice', '>=', $filters->minPrice);
        }

        if ($filters->maxPrice != 0) {
            $query->where('minPrice', '<=', $filters->maxPrice);
        }

        if ($filters->start_date) {
            $query->whereDate('startDate', '=', $filters->start_date);
        }

        if ($filters->end_date) {
            $query->whereDate('endDate', '=', $filters->end_date);
        }

        if ($filters->objects) {
            // TODO: Implement objects filter
        }

        if ($filters->foods) {
            foreach ($filters->foods as $food) {
                $query->whereHas('foods', function ($subQuery) use ($food) {
                    $subQuery->where('typeFood_id', $food['id']);
                });
            }
        }

        if ($filters->services) {
            // TODO: Implement services filter
        }

        if ($filters->infrastructures) {
            // TODO: Implement infrastructures filter
        }
    }
}
