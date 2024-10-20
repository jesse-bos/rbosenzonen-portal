<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function getStartTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['start_time']);
    }

    public function getEndTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['end_time']);
    }
}
