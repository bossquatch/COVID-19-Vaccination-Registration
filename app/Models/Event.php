<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function location() {
        return $this->belongsTo(Location::class, 'location_id')->withTrashed();
    }

    public function slots() {
        return $this->hasMany(Slot::class, 'event_id');
    }

    public function lots() {
        return $this->belongsToMany(Lot::class)->withTimestamps();
    }

    public function getLotNumbersAttribute() {
        return implode(", ", $this->lots()->pluck('number')->toArray());
    }

    // allows $event->percent_filled
    public function getPercentFilledAttribute() {
        $filled = $capacity = 0;
        foreach ($this->slots as $slot) {
            $filled += $slot->active_invitation_count;
            $capacity += $slot->capacity;
        }
        return floor(($filled / $capacity) * 100) . '%';
    }

    // allows $event->start_time
    public function getStartTimeAttribute() {
        return $this->slots()->orderBy('starting_at', 'asc')->first()->starting_at ?? 'N/A';
    }

    // allows $event->end_time
    public function getEndTimeAttribute() {
        return $this->slots()->orderBy('ending_at', 'desc')->first()->ending_at ?? 'N/A';
    }
}
