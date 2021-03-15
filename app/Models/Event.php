<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use mysql_xdevapi\Exception;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot() {
        parent::boot();

        self::deleting(function (Event $event) {
            foreach ($event->slots as $slot) {
                $slot->delete();
            }
        });
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id')->withTrashed();
    }

    public function settings(): HasOne
    {
        return $this->hasOne(Settings::class, 'event_id');
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class, 'event_id');
    }

    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class)->withTimestamps();
    }

    public function eventMessage(): HasOne
    {
    	return $this->hasOne(EventMessage::class,'event_id');
    }

    public function hasMessage(): bool
    {
		return $this->eventMessage->exists();
    }

    public function invitations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Invitation::class,
            Slot::class,
            'event_id', // Foreign key on the slots table...
            'slot_id', // Foreign key on the invitations table...
            'id', // Local key on the events table...
            'id' // Local key on the slots table...
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function intersectsSlot(\Carbon\CarbonPeriod $period): bool
    {
        foreach ($this->slots as $slot) {
            if ($slot->intersects($period)) {
                return true;
            }
        }
        return false;
    }

    public function withinEvent(\Carbon\Carbon $time): bool
    {
        foreach ($this->slots as $slot) {
            if ($slot->withinTime($time)) {
                return true;
            }
        }
        return false;
    }

    public function getLotNumbersAttribute() {
        return implode(", ", $this->lots()->pluck('number')->toArray());
    }

    public function getPartnersAttribute() {
        return implode(", ", $this->tags()->pluck('label')->toArray());
    }

    // allows $event->total_capacity
    public function getTotalCapacityAttribute() {
        $capacity = 0;
        foreach ($this->slots as $slot) {
            $capacity += $slot->capacity;
        }
        return $capacity;
    }

    public function getTotalAvailabilityAttribute() {
        return $this->total_capacity - ($this->total_invites + $this->total_reserved);
    }

    public function getTotalAwaitingResponseFromAttribute() {
        return $this->total_invites - ($this->total_scheduled + $this->total_awaiting_callback);
    }

    // allows $event->total_invites
    public function getTotalInvitesAttribute() {
        $capacity = 0;
        foreach ($this->slots as $slot) {
            $capacity += $slot->active_invitation_count;
        }
        return $capacity;
    }

    // allows $event->total_scheduled
    public function getTotalScheduledAttribute() {
        $capacity = 0;
        foreach ($this->slots as $slot) {
            $capacity += $slot->scheduled_count;
        }
        return $capacity;
    }

    // allows $event->total_reserved
    public function getTotalReservedAttribute() {
        $capacity = 0;
        foreach ($this->slots as $slot) {
            $capacity += $slot->reserved;
        }
        return $capacity;
    }

    // allows $event->total_awaiting_callback
    public function getTotalAwaitingCallbackAttribute() {
        $capacity = 0;
        foreach ($this->slots as $slot) {
            $capacity += $slot->callback_count;
        }
        return $capacity;
    }

    // allows $event->percent_filled
    public function getPercentFilledAttribute() {
        $filled = $capacity = 0;
        foreach ($this->slots as $slot) {
            $filled += $slot->scheduled_count + $slot->reserved;
            $capacity += $slot->capacity;
        }
        return floor(($filled / $capacity) * 100) . '%';
    }

    // allows $event->percent_filled
    public function getPercentInvitedAttribute() {
        $filled = $capacity = 0;
        foreach ($this->slots as $slot) {
            $filled += $slot->active_invitation_count + $slot->reserved;
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

    public function getEdittableAttribute() {
        return (!$this->open && $this->invitations()->count() == 0);
    }

    public function getHeldIntervalsAttribute() {
        return new \Carbon\CarbonPeriod($this->date_held . ' 06:00', '15 minutes', $this->date_held . ' 22:00');
    }

    public function getToCheckInAttribute() {
        return $this->invitations()->whereIn('invite_status_id', [6])->count();
    }

    public function getCheckedInAttribute() {
        return $this->invitations()->whereIn('invite_status_id', [7, 10])->count();
    }

    public function getStartableAttribute() {
        $times = [];

        foreach ($this->held_intervals as $date) {
            dump($date);
            $time = \Carbon\Carbon::parse($date);
            if (!$this->withinEvent($time)) {
                $times[] = $date;
            }
        }

        return $times;
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
