<?php

namespace App\Models\Tender;

use App\Filters\QueryFilter;
use App\Models\City;
use App\Models\Deal\Deal;
use App\Models\Profile\InfoCompany;
use App\Models\SportType;
use App\Models\User;
use App\Traits\HasLocalDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Tender extends Model
{
    const STATUS_NEW = 0;
    const STATUS_DEAL = 1;
    const STATUS_REJECTED_CUSTOMER = 2;
    const STATUS_REJECTED_EXECUTOR = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_COMPLETE_ARBITER = 5;
    use HasFactory;
    use HasLocalDates;

    protected static function bootHasLocalDatesTrait()
    {
        foreach (static::getDates() as $dateField) {
            static::creating(function ($model) use ($dateField) {
                $model->setLocalDateTimeAttribute($model->$dateField, $dateField);
            });

            static::updating(function ($model) use ($dateField) {
                $model->setLocalDateTimeAttribute($model->$dateField, $dateField);
            });
        }
    }

    protected $fillable = [
        'infoCompany_id', 'city_id', 'startDate', 'endDate',
        'spreadDate', 'colPeople', 'priceForPerson', 'minPrice',
        'createDate', 'user_id', 'comment', 'archive', 'feedback', 'rating', 'accred'
    ];

    protected $casts = [
        'id' => 'integer',
        'infoCompany_id' => 'integer',
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
        'rating' => 'double',
        'accred' => 'bool'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function infoCompany()
    {
        return $this->belongsTo(InfoCompany::class, 'infoCompany_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function responses()
    {
        return $this->belongsToMany(ResponsesTender::class, 'responses_tender_and_tenders',
            'tender_id', 'responsesTender_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'id', 'tender_id');
    }

    public function additions()
    {
        return $this->belongsToMany(AdditionTender::class, 'tenders_and_additions', 'tender_id', 'additionTender_id');
    }

    public function foods()
    {
        return $this->belongsToMany(TypeFood::class, 'tenders_and_type_foods', 'tender_id', 'typeFood_id');
    }

    public function sports()
    {
        return $this->belongsToMany(SportType::class, 'tenders_and_type_sports', 'tender_id', 'sportType_id');
    }

    public function infrastructures(): BelongsToMany
    {
        return $this->belongsToMany(RequirementInfrastructures::class, 'tenders_and_infrastructures', 'tender_id', 'infrastructure_id');
    }


    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    public function scopeActive($query)
    {
        return $query->with('deal')
            ->whereIn('archive', [Tender::STATUS_NEW, Tender::STATUS_DEAL])
            ->whereDate('startDate', '>', now())
            ->where(function ($query) {
                $query->whereHas('deal', function ($q) {
                    $q->where('step', '<', 2);
                })->orWhere(function ($query) {
                    $query->doesntHave('deal');
                });
            });
    }

    public function scopeArchive($query)
    {
        return $query->with(['deal', 'responses'])
            ->where(function ($query) {
                $query->whereIn('archive', [
                    Tender::STATUS_REJECTED_CUSTOMER,
                    Tender::STATUS_REJECTED_EXECUTOR,
                    Tender::STATUS_COMPLETE,
                    Tender::STATUS_COMPLETE_ARBITER
                ])->orWhere(function ($query) {
                    $query->where('archive', Tender::STATUS_NEW)
                        ->where(function ($query) {
                            $query->whereDate('startDate', '<', now())
                                ->orWhere(function ($query) {
                                    $query->whereHas('deal');
                                });
                        });
                });
            });

    }

    public function scopeHasUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function scopeWithSort($query, $filters)
    {
        if ($filters->sort == null) return $query->orderBy('created_at', "desc");
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
        });
    }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->searchTender, function ($query) use ($filters) {
            $query->where('comment', 'like', "%$filters->searchTender%")->orWhere('id', 'like', "%$filters->searchTender%");
        })->when($filters->col['id'] != 0, function ($query) use ($filters) {
            $query->where('colPeople', '<', $filters->col['col']);
        })->when($filters->price['id'] != 0, function ($query) use ($filters) {
            $query->where('priceForPerson', '<', $filters->price['col']);
        })->when($filters->region, function ($query) use ($filters) {
            $query->whereHas('city', function ($query) use ($filters) {
                return $query->whereHas('region', function ($query) use ($filters) {
                    $query->whereIn('id', collect($filters->region)->pluck('id'));
                });
            });
        })->when($filters->sports, function ($query) use ($filters) {
            foreach ($filters->sports as $sport) {
                $query->whereHas('sports', function ($subQuery) use ($sport) {
                    $subQuery->where('sportType_id', $sport['id']);
                });
            }
        })->when($filters->dateStart, function ($query) use ($filters) {
            $query->whereDate('startDate', '>=', $filters->dateStart);
        })->when($filters->dateEnd, function ($query) use ($filters) {
            $query->whereDate('endDate', '<=', $filters->dateEnd);
        })->when($filters->responses, function ($query) {
            $query->whereHas('responses', function ($query) {
                $query->where('user_id', '=', Auth::id())->where('archive', '=', 0);
            });
        })->when($filters->requests, function ($query) {
            $query->where('user_id', '=', Auth::id());
        });
    }

    public function scopeWithFiltersToApplicationsTender($query, $filters)
    {
        $query->when($filters->search, function ($query) use ($filters) {
            $query->where('comment', 'like', "%$filters->search%")
                ->orWhere('id', 'like', "%$filters->search%");
        })
            ->when($filters->minPrice != 0, function ($query) use ($filters) {
                $query->where('minPrice', '>=', $filters->minPrice);
            })
            ->when($filters->maxPrice != 0, function ($query) use ($filters) {
                $query->where('minPrice', '<=', $filters->maxPrice);
            })
            ->when(isset($filters->start_date), function ($query) use ($filters) {
                $dateStart = date('Y-m-d', strtotime($filters->start_date));
                $query->whereDate('startDate', '=', $dateStart);
            })
            ->when(isset($filters->end_date), function ($query) use ($filters) {
                $dateEnd = date('Y-m-d', strtotime($filters->end_date));
                $query->whereDate('endDate', '=', $dateEnd);
            })
            ->when($filters->foods, function ($query) use ($filters) {
                foreach ($filters->foods as $food) {
                    $query->whereHas('foods', function ($subQuery) use ($food) {
                        $subQuery->where('typeFood_id', $food['id']);
                    });
                }
            })
            ->when($filters->services, function ($query) use ($filters) {
                foreach ($filters->services as $service) {
                    $query->whereHas('additions', function ($subQuery) use ($service) {
                        $subQuery->where('additionTender_id', $service['id']);
                    });
                }
            })
            ->when($filters->infrastructures, function ($query) use ($filters) {
                foreach ($filters->infrastructures as $infrastructure) {
                    $query->whereHas('infrastructures', function ($subQuery) use ($infrastructure) {
                        $subQuery->where('infrastructure_id', $infrastructure['id']);
                    });
                }
            });


        // TODO: Add when clauses for objects, infrastructures.

        // Uncomment the following line to print the final SQL query for debugging purposes.
        // dd($query->toSql(), $query->getBindings());
    }
}
