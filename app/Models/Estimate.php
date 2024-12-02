<?php

namespace App\Models;

use App\Models\Deal\Deal;
use App\Traits\HasLocalDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Estimate extends Model
{
    use HasFactory, HasLocalDates;

    const ESTIMATE_NOTIF_PAYMENT = 1;
    const ESTIMATE_CONFIRMATION = 2;
    const ESTIMATE_PAYMENT = 3;
    const ESTIMATE_OVERDUE = 4;
    const ESTIMATE_PAYMENT_EXECUTOR = 5;

    protected $fillable = [
        'status', 'sportObject_id', 'deal_id', 'payment_at_executor', 'date_payment', 'payment_confirm_date',
        'payment_overdue_date', 'replay_estimate', 'rentSportObject_id',
        'rentAccommodation_id', 'rentAddition_id', 'sum', 'show_executor', 'date_send_customer', 'documents',
        'date_payment_to_executor', 'payment_doc'
    ];
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'sportObject_id' => 'integer',
        'deal_id' => 'integer',
        'payment_at_executor' => 'boolean',
        'replay_estimate' => 'boolean',
        'rentSportObject_id' => 'integer',
        'rentAccommodation_id' => 'integer',
        'rentAddition_id' => 'integer',
        'sum' => 'float',
        'show_executor' => 'boolean',
        'date_payment' => 'datetime',
        'payment_confirm_date' => 'datetime',
        'payment_overdue_date' => 'datetime',
        'date_send_customer' => 'datetime',
        'documents' => 'array',
        'date_payment_to_executor' => 'datetime'
    ];

    protected $appends = ['is_overdue'];
    protected $dates = ['payment_overdue_date'];

    public function getIsOverdueAttribute()
    {
        return $this->payment_overdue_date && $this->payment_overdue_date->isPast();
    }

    public function rentSportObject()
    {
        return $this->belongsTo(\App\Models\rentSportObject::class, 'rentSportObject_id');
    }

    public function rentAccomodation()
    {
        return $this->belongsTo(\App\Models\rentAccommodation::class, 'rentAccommodation_id');
    }

    public function rentAddition()
    {
        return $this->belongsTo(\App\Models\rentAddition::class, 'rentAddition_id');
    }

    public function sportObject()
    {
        return $this->belongsTo(SportObject::class, 'sportObject_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function scopeLastEstimate($query)
    {
        $lastEstimates = Estimate::select('deal_id', DB::raw('MAX(created_at) as last_created_at'))
            ->groupBy('deal_id')
            ->get();

        $query->whereIn(DB::raw('(deal_id, created_at)'), function ($query) use ($lastEstimates) {
            $query->select('deal_id', DB::raw('MAX(created_at) as last_created_at'))
                ->from('estimates')
                ->whereIn('deal_id', $lastEstimates->pluck('deal_id')->toArray())
                ->groupBy('deal_id');
        });
    }

    public function scopeHasUser($query)
    {
        $query->whereHas('deal', function ($q) {
            $q->with('tender', 'responsesTender', 'direct')
                ->whereHas('tender', function ($q) {
                    $q->where('user_id', Auth::id());
                })->orWhereHas('responsesTender', function ($q) {
                    $q->where('user_id', Auth::id());
                })->orWhereHas('direct', function ($q) {
                    $q->where('user_id', Auth::id());
                });
        });
    }

    public function scopeHasDeal($query)
    {
        $query->whereHas('deal');
    }

    public function scopeHasDealComplete($query)
    {
        $query->whereHas('deal', function ($query) {
            $query->where('complete', 1)->orWhere('complete', 2);
        });
    }

    public function scopeHasLastEstimate($query)
    {
        $query->where(function ($query) {
            $query->whereIn('id', function ($subquery) {
                $subquery->selectRaw('MAX(id)')
                    ->from('estimates')
                    ->groupBy('deal_id');
            });
        });
    }

    public function scopeHasRequest($query)
    {
        $query->whereHas('deal.tender')->orWhereHas('deal.responsesTender');
    }
}
