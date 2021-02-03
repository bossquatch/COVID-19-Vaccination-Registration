<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = [];
    public $timestamps = false;

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

    // allows $slot->has_stock
    public function getHasStockAttribute() {
        return (($this->active_invitation_count + $this->reserved) < $this->capacity);
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

    private function activeInvitationQuery() {
        return $this->invitations()->whereHas('invite_status', function (Builder $query) {
            $query->whereNotIn('id', [4, 5]);
        });
    }
}
