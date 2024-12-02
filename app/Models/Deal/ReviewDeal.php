<?php

namespace App\Models\Deal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReviewDeal extends Model
{
    use HasFactory;

    const STATUS_MODERATION = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'deal_id', 'infrastructure', 'sport_object', 'food', 'territory', 'place',
        'price', 'text', 'status', 'reasonDeleted'
    ];
    protected $table = "reviews_deals";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'status' => 'integer',
        'deal_id' => 'integer',
        'infrastructure' => 'double',
        'sport_object' => 'double',
        'food' => 'double',
        'territory' => 'double',
        'place' => 'double',
        'price' => 'double',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeComplete($query)
    {
        $query->with('deal')->whereHas('deal', function ($q) {
            $q->where('complete', 1);
        });
    }

    public function scopeHasUser($query)
    {
        $query->with('deal')->whereHas('deal.tender', function ($q) {
            $q->where('user_id', Auth::id());
        })->orWhereHas('deal.direct', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }

    public function scopeSortReviews($query, $filters)
    {
        return $query->when($filters->status == 'new', function ($query) {
            $query->orderBy('created_at');
        })->when($filters->status == 'bad', function ($query) {
            $query->selectRaw('*, (infrastructure + sport_object + food + territory + place + price) / 6 as average')
                ->groupBy('id')
                ->orderBy('average');
        })->when($filters->status == 'best', function ($query) {
            $query->selectRaw('*, (infrastructure + sport_object + food + territory + place + price) / 6 as average')
                ->groupBy('id')
                ->orderBy('average', 'desc');
        });
        /* return $query->when($filters->sort == 'new', function ($query) {
                 $query->orderBy('created_at', 'desc');
             })->when($filters->sort == 'bad', function ($query) {
                 $query->selectRaw('`reviews_deals`.*, ((COALESCE(`food`) + COALESCE(`territory`) + COALESCE(`place`)
                     + COALESCE(`sport_object`) + COALESCE(`infrastructure`) + COALESCE(`price`))/5) AS `avg`')
                     ->orderBy('avg');
             })->when($filters->sort == 'best', function ($query) {
                 $query->selectRaw('`reviews_deals`.*, ((COALESCE(`food`) + COALESCE(`territory`) + COALESCE(`place`)
                     + COALESCE(`sport_object`) + COALESCE(`infrastructure`) + COALESCE(`price`))/5) AS `avg`')
                     ->orderBy('avg', 'desc');
             });*/
    }

    public function scopeReviewsForSportObject($query, $sportObject_id)
    {
        return $query->whereHas('deal', function ($query) use ($sportObject_id) {
            $query->with(['direct', 'responsesTender'])
                ->whereHas('direct', function ($query) use ($sportObject_id) {
                    $query->where('sportObject_id', '=', $sportObject_id);
                })
                ->orWhereHas('responsesTender', function ($query) use ($sportObject_id) {
                    $query->where('sportObject_id', '=', $sportObject_id);
                });
        });
    }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->search, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('responsesTender', function ($q) use ($filters) {
                    $q->where('comment', 'like', "%$filters->search%")
                        ->orWhere('id', 'like', "%$filters->search%");
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('comment', 'like', "%$filters->search%")
                        ->orWhere('id', 'like', "%$filters->search%");
                });
            });
        })->when($filters->minPrice, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('responsesTender', function ($q) use ($filters) {
                    $q->where('minPrice', '>=', $filters->minPrice);
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('minPrice', '>=', $filters->minPrice);
                });
            });
        })->when($filters->maxPrice, function ($query) use ($filters) {
            $query->where(function ($sub) use ($filters) {
                $sub->whereHas('responsesTender', function ($q) use ($filters) {
                    $q->where('minPrice', '<=', $filters->maxPrice);
                })->orWhereHas('direct', function ($q) use ($filters) {
                    $q->where('minPrice', '<=', $filters->maxPrice);
                });
            });
        })->when($filters->start_date, function ($query) use ($filters) {
            $query->whereHas('responsesTender', function ($q) use ($filters) {
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
            $query->whereHas('responsesTender', function ($q) use ($filters) {
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
                $sub->whereHas('responsesTender', function ($q) use ($filters) {
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
                $sub->whereHas('responsesTender', function ($q) use ($filters) {
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
