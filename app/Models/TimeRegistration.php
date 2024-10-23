<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class TimeRegistration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'breaktime_minutes' => 'integer',
            'mileage' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getWorkHoursAttribute(): string
    {
        $startTime = $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : 'N/A';
        $endTime = $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : 'N/A';

        return "{$startTime} - {$endTime}";
    }

    public function getWorkDurationAttribute(): string
    {
        if (!$this->start_time || !$this->end_time) {
            return 'N/A';
        }
    
        // Start- en eindtijd omzetten naar Carbon instances
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);

        if ($this->start_time > $this->end_time) {
            return '-';
        }
        
        $totalMinutes = $startTime->diffInMinutes($endTime);
    
        $workMinutes = $totalMinutes - $this->breaktime_minutes;
    
        return CarbonInterval::minutes($workMinutes)->cascade()->forHumans();
    }
}
