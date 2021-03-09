<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'starting_at',
        'ending_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot() {
        parent::boot();

        self::deleting(function (Slot $slot) {
            foreach ($slot->invitations as $invite) {
                $invite->delete();
            }
        });
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function invitations() {
        return $this->hasMany(Invitation::class, 'slot_id');
    }

    public function registrations() {
        return $this->hasManyThrough(
            Registration::class,
            Invitation::class,
            'slot_id', // Foreign key on the invitations table...
            'id', // Foreign key on the registrations table...
            'id', // Local key on the slots table...
            'registration_id' // Local key on the invitations table...
        );
    }

    public function intersects(\Carbon\CarbonPeriod $period) {
        return $period->overlaps($this->carbon_period);
    }

    public function withinTime(\Carbon\Carbon $time) {
        return $time->between(\Carbon\Carbon::parse($this->starting_at), \Carbon\Carbon::parse($this->ending_at)->sub('1 minute'));
    }

    // allows $slot->has_stock
    public function getHasStockAttribute() {
        return (($this->active_invitation_count + $this->reserved) < $this->capacity);
    }

    public function getCarbonPeriodAttribute() {
        return new \Carbon\CarbonPeriod($this->starting_at, '15 minutes', $this->ending_at);
    }

    // allows $slot->stock
    public function getStockAttribute() {
        return ($this->capacity - ($this->active_invitation_count + $this->reserved));
    }

    // allows $slot->partner_handled
    public function getPartnerHandledAttribute() {
        return ($this->event->partner_handled);
    }

    // allows $slot->active_invitation_list
    public function getActiveInvitationListAttribute() {
        return $this->activeInvitationQuery()->get();
    }

    // allows $slot->active_invitation_count
    public function getActiveInvitationCountAttribute() {
        return $this->activeInvitationQuery()->count();
    }

    // allows $slot->scheduled_count
    public function getScheduledCountAttribute() {
        return $this->invitations()->whereHas('invite_status', function (Builder $query) {
            $query->whereNotIn('id', [1, 2, 3, 4, 5]);
        })->count();
    }

    public function getCallbackCountAttribute() {
        return $this->invitations()->whereHas('invite_status', function (Builder $query) {
            $query->where('id', 2);
        })->count();
    }

    private function activeInvitationQuery() {
        return $this->invitations()->whereHas('invite_status', function (Builder $query) {
            $query->whereNotIn('id', [4, 5]);
        });
    }
}
