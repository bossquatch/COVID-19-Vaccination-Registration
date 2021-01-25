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

    public function invitations() {
        return $this->hasManyThrough(
            Invitation::class,
            Slot::class,
            'event_id', // Foreign key on the slots table...
            'slot_id', // Foreign key on the invitations table...
            'id', // Local key on the events table...
            'id' // Local key on the slots table...
        );
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

    public function getHasPendingCallbacksAttribute() {
        return ($this->slots()->whereHas('invitations', function ($query) {
            $query->whereHas('invite_status', function ($query) {
                $query->where('name', 'Awaiting Callback');
            });
        })->count() > 0);
    }

    public function pending_callbacks_query() {
        return $this->invitations()->whereHas('invite_status', function ($query) {
            $query->where('name', 'Awaiting Callback');
        });
    }
}
