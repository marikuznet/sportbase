<?php

namespace App\Models\Deal;

use App\Models\DirectApplications;
use App\Models\Estimate;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use App\Traits\HasLocalDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Deal extends Model
{
    use HasFactory, HasLocalDates;

    /**Шаги сделки*/
    const STATUS_GET_PAYMENT = 2;
    const STATUS_CONFIRMATION = 3;
    const STATUS_DEAL_FINISH = 4;
    const STATUS_REVIEW = 5;

    const STATUS_ARBITR_CUSTOMER = 6;
    const STATUS_ARBITR_EXECUTOR = 7;

    /**Статусы выполнения*/
    const COMPLETE_SUCCESS = 1;
    const COMPLETE_ARBITR = 2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tender_id', 'directApplication_id', 'responsesTender_id',
        'rejectionsDeal', 'status', 'accept_by_customer', 'accept_by_executor',
        'accept_customer_date', 'accept_executor_date', 'step', 'completed_at', 'confirmed_at',
        'reason_canceled'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tender_id' => 'integer',
        'directApplication_id' => 'integer',
        'reponsesTender_id' => 'integer',
        'rejectionsDeal' => 'array',
        'status' => 'integer',
        'step' => 'integer',
        'accept_by_customer' => 'integer',
        'accept_by_executor' => 'integer',
        'accept_customer_date' => 'date',
        'accept_executor_date' => 'date',
        'completed_at' => 'datetime',
        'confirmed_at' => 'datetime'
    ];

    //protected $with = ['responsesTender'];

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }

    public function responsesTender(): BelongsTo
    {
        return $this->belongsTo(ResponsesTender::class, 'responsesTender_id');
    }

    public function direct(): BelongsTo
    {
        return $this->belongsTo(DirectApplications::class, 'directApplication_id');
    }

    public function directApplication()
    {
        return $this->belongsTo(DirectApplications::class);
    }

    public function reviews()
    {
        return $this->hasMany(ReviewDeal::class, 'deal_id');
    }

    public function review()
    {
        return $this->hasOne(ReviewDeal::class, 'deal_id');
    }

    public function estimates(): BelongsTo
    {
        return $this->belongsTo(Estimate::class, 'id', 'deal_id');
    }

    public function scopeHasUser($query)
    {
        $query->with('direct', 'responsesTender', 'tender')->where(function ($query) {
            $query->whereHas('tender', function ($q) {
                $q->where('user_id', Auth::id());
            })->orWhereHas('responsesTender', function ($q) {
                $q->where('user_id', Auth::id());
            });
        })->orWhere(function ($query) {
            $query->whereHas('direct.sportObject', function ($q) {
                $q->where('user_id', Auth::id());
            })->orWhereHas('direct', function ($q) {
                $q->where('user_id', Auth::id());
            });
        });
    }

    public function scopeActive($query)
    {
        $query->whereIn('step', [1, self::STATUS_GET_PAYMENT, self::STATUS_CONFIRMATION, self::STATUS_ARBITR_EXECUTOR, self::STATUS_ARBITR_CUSTOMER])
        ->where('complete', 0)
        ->where('status', 0);
    }

    public function scopeFinish($query)
    {
        $query->whereIn('step', [self::STATUS_DEAL_FINISH, self::STATUS_REVIEW])
        ->orWhereIn('complete', [self::COMPLETE_SUCCESS, self::COMPLETE_ARBITR])
        ->orWhereIn('status', [1,2,3]);
    }

    public function scopeHasSportObject($query)
    {
        $query->whereHas('direct.sportObject')->orWhereHas('responsesTender.sportObject');
    }

    public function scopeWithFilters($query, $filters)
    {
        $query->when($filters->search, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('tender', function ($q) use ($filters) {
                    $q->where('comment', 'like', "%$filters->search%")
                        ->orWhere('id', 'like', "%$filters->search%");
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('comment', 'like', "%$filters->search%")
                        ->orWhere('id', 'like', "%$filters->search%");
                });
            });
        })->when($filters->minPrice, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('tender', function ($q) use ($filters) {
                    $q->where('minPrice', '>=', $filters->minPrice);
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('minPrice', '>=', $filters->minPrice);
                });
            });
        })->when($filters->maxPrice, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('tender', function ($q) use ($filters) {
                    $q->where('minPrice', '<=', $filters->maxPrice);
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('minPrice', '<=', $filters->maxPrice);
                });
            });
        })->when($filters->start_date, function ($query) use ($filters) {
            $query->whereHas('tender', function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $dateStart = date('Y-m-d', strtotime($filters->start_date));
                    $sub->whereDate('startDate', '=', $dateStart);
                });
            })->orWhereHas('direct', function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $dateStart = date('Y-m-d', strtotime($filters->start_date));
                    $sub->whereDate('startDate', '=', $dateStart);
                });
            });
        })->when($filters->end_date, function ($query) use ($filters) {
            $query->whereHas('tender', function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $dateEnd = date('Y-m-d', strtotime($filters->end_date));
                    $sub->whereDate('endDate', '=', $dateEnd);
                });
            })->orWhereHas('direct', function ($q) use ($filters) {
                $q->where(function ($sub) use ($filters) {
                    $dateEnd = date('Y-m-d', strtotime($filters->end_date));
                    $sub->whereDate('endDate', '=', $dateEnd);
                });
            });
        })->when($filters->foods, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('tender', function ($q) use ($filters) {
                    foreach ($filters->foods as $food) {
                        $q->whereHas('foods', function ($subQuery) use ($food) {
                            $subQuery->where('typeFood_id', $food['id']);
                        });
                    }
                })->orWhereHas('direct', function ($q) use ($filters) {
                    foreach ($filters->foods as $food) {
                        $q->whereHas('foods', function ($subQuery) use ($food) {
                            $subQuery->where('typeFood_id', $food['id']);
                        });
                    }
                });
            });
        })->when($filters->services, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('tender', function ($q) use ($filters) {
                    foreach ($filters->services as $service) {
                        $q->whereHas('additions', function ($subQuery) use ($service) {
                            $subQuery->where('additionTender_id', $service['id']);
                        });
                    }
                })->orWhereHas('direct', function ($q) use ($filters) {
                    foreach ($filters->services as $service) {
                        $q->whereHas('additions', function ($subQuery) use ($service) {
                            $subQuery->where('additionTender_id', $service['id']);
                        });
                    }
                });
            });
        });
    }
}
