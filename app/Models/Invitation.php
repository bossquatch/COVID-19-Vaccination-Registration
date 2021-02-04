<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = ['slot_id', 'registration_id'];
    public $incrementing = false;

    protected $guarded = [];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

    public function registration() {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function slot() {
        return $this->belongsTo(Slot::class, 'slot_id');
    }

    public function invite_status() {
        return $this->belongsTo(InviteStatus::class, 'invite_status_id');
    }

    public function contact_method() {
        return $this->belongsTo(ContactMethod::class, 'contact_method_id');
    }

    public function event() {
        return $this->hasOneThrough(
            Event::class,
            Slot::class,
            'id', // Foreign key on the slots table...
            'id', // Foreign key on the events table...
            'slot_id', // Local key on the invitations table...
            'event_id' // Local key on the slots table...
        );
    }

    public function user() {
        return $this->hasOneThrough(
            User::class,
            Registration::class,
            'id', // Foreign key on the registrations table...
            'id', // Foreign key on the users table...
            'registration_id', // Local key on the invitations table...
            'user_id' // Local key on the registrations table...
        );
    }

    // allows $invitation->auto_contactable
    public function getAutoContactableAttribute() {
        return ($this->user->sms_verified_at || $this->user->email_verified_at);
    }

    // allows $invitation->can_sms
    public function getCanSmsAttribute() {
        return ($this->user->sms_verified_at);
    }

    // allows $invitation->can_email
    public function getCanEmailAttribute() {
        return ($this->user->email_verified_at);
    }

    // allows $invitation->partner_handled
    public function getPartnerHandledAttribute() {
        return ($this->slot->partner_handled);
    }

    // allows $invitation->contact_name; returns a full name, "System Automated", "Not Contacted", or "N/A"
    public function getContactNameAttribute() {
        if ($this->contact_method) {
            if ($this->contact_method->is_system) {
                return "System Automated";
            } else {
                $user = User::withTrashed()->find($this->contacted_by);
                if ($user) {
                    return $user->first_name.' '.$user->last_name;
                } else {
                    return "N/A";
                }
            }
        } else {
            return "Not Contacted";
        }
    }
}
