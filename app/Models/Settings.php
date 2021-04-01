<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Settings extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function occupations()
    {
        return $this->belongsToMany(Occupation::class)->withTimestamps();
    }

    public function conditions()
    {
        return $this->belongsToMany(Condition::class)->withTimestamps();
    }

    public function getEstimateCountAttribute()
    {
        $slot_ids = $this->event->slots()->pluck('id')->toArray();
        $date = Carbon::parse($this->event->date_held)->format('Y-m-d');

        return Registration::has('vaccines', '<', 2)                                    // don't grab those with both vaccinations
            ->has('user')
            ->whereHas('status', function (Builder $query) {                            // only grab registrations in a wait list
                $query->whereIn('name', ['In Wait List', 'Waitlist - 2nd Shot']);
            })->whereDoesntHave('vaccines', function (Builder $query) use ($date) {     // don't grab those who have waited too long or too little for second vaccine
                $query->whereRaw('DATEDIFF("' . $date . '", date_given) < 26')
                    ->orWhereRaw('DATEDIFF("' . $date . '", date_given) > 30');
            })->whereDoesntHave('invitations', function (Builder $query) use ($slot_ids) {
                $query->whereIn('slot_id', $slot_ids);                                  // don't invite those who have had invitations to the same slot
            })->where($this->queryMods())                                               // base of callback mods
            ->where(function ($query) {
                $query->doesntHave('address')
                    ->orWhereHas('address.state', function ($query) {
                        $query->where('abbr', '=', 'FL');
                    });
            })->count();
    }

    /**
     * ONLY QUERY REGISTRATION MODELS UTILIZING THIS FUNCTION
     */
    public function queryMods()
    {
        $self = $this;

        return function (Builder $query) use ($self) {
            if ($self->age_min !== null) {
                $age_limit = Carbon::today()->subYears($self->age_min);
                $query->where('birth_date', '<=', $age_limit);
            }

            if ($self->age_max !== null) {
                $age_limit = Carbon::today()->subYears(((int) $self->age_max) + 1);
                $query->where('birth_date', '>', $age_limit);
            }

            if ($self->vulnerability_min !== null) {
                $query->whereHas('conditions', function (Builder $query) {
                    $query->select(DB::raw('SUM(`score`) as score'));
                }, '>=', $self->vulnerability_min);
            }

            if ($self->vulnerability_max !== null) {
                $query->whereHas('conditions', function (Builder $query) {
                    $query->select(DB::raw('SUM(`score`) as score'));
                }, '<=', $self->vulnerability_max);
            }

            if ($self->latitude !== null && $self->longitude !== null && $self->search_radius !== null) {
                $R = 3959;

                // first-cut bounding box (in degrees)
                $maxLat = $self->latitude + rad2deg($self->search_radius/$R);
                $minLat = $self->latitude - rad2deg($self->search_radius/$R);
                // compensate for degrees longitude getting smaller with increasing latitude
                $maxLon = $self->longitude + rad2deg($self->search_radius/$R/cos(deg2rad($self->latitude)));
                $minLon = $self->longitude - rad2deg($self->search_radius/$R/cos(deg2rad($self->latitude)));

                $lat = deg2rad($self->latitude);
                $lon = deg2rad($self->longitude);

                $query->whereHas('address', function (Builder $query) use ($self, $R, $minLat, $maxLat, $minLon, $maxLon, $lat, $lon) {
                    $query->whereBetween('latitude', [$minLat, $maxLat])
                        ->whereBetween('longitude', [$minLon, $maxLon])
                        ->where(DB::raw("acos(sin({deg2rad($lat)})*sin(radians(`latitude`)) + cos({$lat})*cos(radians(`latitude`))*cos(radians(`longitude`)-{$lon})) * {$R}"), '<', $self->search_radius);
                });
            }

            if ($self->zips_string !== null) {
                $zips = explode(',',$self->zips_string);
                $query->whereHas('address', function (Builder $query) use ($zips) {
                    $query->whereIn('postal_code', $zips);
                });
            }

            if ($self->conditions()->count() > 0) {
                $conditions = $self->conditions()->pluck('id')->toArray();
                $query->whereHas('conditions', function (Builder $query) use ($conditions) {
                    $query->whereIn('id', $conditions);
                });
            }

            if ($self->occupations()->count() > 0) {
                $occupations = $self->occupations()->pluck('id')->toArray();
                $query->whereIn('occupation_id', $occupations);
            }

            if ($self->polk_only) {
                $query->whereHas('address', function (Builder $query) {
                    $query->where('county_id', 53);
                });
            }
        };
    }
}
