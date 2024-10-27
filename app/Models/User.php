<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\CarbonInterval;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /* -------------------- Relationships -------------------- */

    public function timeRegistrations(): HasMany
    {
        return $this->hasMany(TimeRegistration::class);
    }

    /* -------------------- Helper functions -------------------- */

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@rbosenzonen.nl');
    }

    public function hasTimeRegistrationForToday(): bool
    {
        return $this->timeRegistrations()->where('date', now()->format('Y-m-d'))->exists();
    }

    public function getHoursThisWeek(): float
    {
        $totalWorkMinutes = $this->timeRegistrations()
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->sum(function ($timeRegistration) {
                $startTime = Carbon::parse($timeRegistration->start_time);
                $endTime = Carbon::parse($timeRegistration->end_time);
    
                if ($timeRegistration->start_time > $timeRegistration->end_time) {
                    return 0;
                }
    
                $totalMinutes = $startTime->diffInMinutes($endTime);
                $workMinutes = $totalMinutes - $timeRegistration->breaktime_minutes;
    
                return $workMinutes;
            });
    
        // Convert total minutes to hours as a float
        $totalWorkHours = $totalWorkMinutes / 60;
    
        return round($totalWorkHours, 2); // Round to 2 decimal places for precision
    }
}
