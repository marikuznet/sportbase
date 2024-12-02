<?php


namespace App\Http\Resources;


use App\Models\SportObject;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class AdvertisementResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'dateStart' => $this->dateStart ? Carbon::parse($this->dateStart)->format('d.m.Y / H:i') : null,
            'dateEnd' => $this->date_end ? Carbon::parse($this->date_end)->format('d.m.Y / H:i') : null,
            'daysOfEnd' => $this->calculateDaysRemaining(),//Carbon::parse($this->paused_at)->diffInDays(Carbon::parse($this->dateStart)),
            'days' => $this->days,
            'amount' => $this->amount,
            'paused' => $this->paused,
            'pause_until' => Carbon::parse($this->pause_until)->format('d.m.Y'),
            'paused_at' => $this->paused_at ? Carbon::parse($this->paused_at)->format('d.m.Y') : null,
            'statusAdvertisment_id' => $this->statusAdvertisment_id,
            'rate' => $this->rateAdvertisment->map(function ($rate) {
                return [
                    'id' => $rate->id,
                    'title' => $rate->title,
                ];
            })[0],
        ];
    }

    #[ArrayShape(['remaining_days' => "int|mixed", 'end_date' => "\Carbon\CarbonInterface|\Carbon\Traits\Date|\Illuminate\Support\Carbon"])] private function calculateDaysRemaining(): array
    {
        $currentDateTime = now();
        $startDate = $this->dateStart;
        $pausedDateTime = $this->paused ? $this->paused_at : $currentDateTime;

        $activeMinutes = $pausedDateTime->diffInMinutes($startDate);
        $daysSincePause = $pausedDateTime->diffInMinutes($currentDateTime) / (24 * 60);
        $remainingDays = $this->days - ($activeMinutes / (24 * 60)) - $daysSincePause;

        $endDate = $currentDateTime->copy()->addDays($remainingDays + 1);

        return [
            'remaining_days' => (int)$remainingDays,
            'end_date' => $endDate,
        ];
    }
}
