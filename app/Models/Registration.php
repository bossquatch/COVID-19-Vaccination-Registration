<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Registration extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = [];

    protected $appends = [
        'email_verified_at',
        'phone_number',
        'age',
	    'address1',
	    'address2',
	    'locality',
	    'state',
	    'postal_code',
	    'county',
	    'latitude',
	    'longitude',
	    'zip',
	    'city',
    ];

    public static function boot() {
        parent::boot();

        self::deleting(function (Registration $r) {
            foreach ($r->invitations as $invite) {
                $invite->delete();
            }
        });
    }

    public function AuditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'regis_id');
    }

    public function AuditChanges(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'registration_id');
    }

    public function emails(): Collection
    {
        return $this->contacts()->where('contact_type_id', 1)->get();
    }

    public function phones(): Collection
    {
        return $this->contacts()->where('contact_type_id', 2)->get();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class, 'race_id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function suffix(): BelongsTo
    {
        return $this->belongsTo(Suffix::class, 'suffix_id');
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(Condition::class)->withTimestamps();
    }

    public function vaccines(): HasMany
    {
        return $this->hasMany(Vaccine::class, 'registration_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'registration_id');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    public function assignEvent(Event $event)
    {
        $this->events()->attach($event);
    }

    public function unassignEvent(Event $event)
    {
        $this->events()->detach($event);
    }

    public function hasComments(): bool
    {
        if ($this->comments()->count() > 0) {
            return true;
        }
        return false;
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'registration_id');
    }

    public function address(): HasOne
    {
		return $this->hasOne(Address::class, 'id', 'address_id');
	}

	public function emailHistory(): HasMany
	{
        return $this->hasMany(EmailHistory::class, 'registration_id', 'id');
    }

    /**
    * Accessor for Age.
    */
    public function getAgeAttribute()
    {
        if ($this->birth_date != null) {
            return Carbon::parse($this->birth_date)->age;
        }
        else {
            return 'N/A';
        }
    }

	/**
	 * Accessor for email verified
	 */
	public function getEmailVerifiedAtAttribute()
	{
		return $this->user->email_verified_at;
	}

    public function getPendingInvitationAttribute()
    {
        return $this->invitations()->whereHas('invite_status', function($query) {
            $query->where('name', 'Awaiting Response')
                ->orWhere('name', 'Awaiting Callback');
        })->first();
    }

    public function getHasAppointmentAttribute(): bool
    {
        return ($this->active_invite_query()->count() > 0);
    }

    public function getAppointmentAttribute()
    {
        return $this->active_invite->slot ?? NULL;
    }

    public function getActiveInviteAttribute()
    {
        return $this->active_invite_query()->first();
    }

    private function active_invite_query()
    {
        return $this->invitations()->whereHas('invite_status', function($query) {
            $query->where('name', 'Accepted')
                ->orWhere('name', 'Checked In');
        });
    }

    public function getPhoneNumberAttribute(): string
    {
        $phone = '+1' . preg_replace('/\D/', '', $this->user->phone);
        return $phone;
    }

    // allows $registration->auto_contactable
    public function getAutoContactableAttribute(): bool
    {
        return ($this->user->sms_verified_at || $this->user->email_verified_at);
    }

    // allows $registration->can_sms
    public function getCanSmsAttribute()
    {
        return ($this->user->sms_verified_at);
    }

    // allows $registration->can_email
    public function getCanEmailAttribute()
    {
        return ($this->user->email_verified_at);
    }

    // Address Sync
    public function syncAddress(array $inputs)
    {
        $inputs = [
            'address_type_id' => 1,
            'street_number' => $inputs['street_number'] ?? null,
            'street_name'   => $inputs['street_name'] ?? null,
            'line_2'        => $inputs['line_2'] ?? null,
            'locality'      => $inputs['locality'] ?? null,
            'county_id'     => $inputs['county'] ?? null,
            'state_id'      => $inputs['state'] ?? null,
            'postal_code'   => $inputs['postal_code'] ?? null,
            'latitude'      => $inputs['latitude'] ?? null,
            'longitude'     => $inputs['longitude'] ?? null,
        ];
        if ($this->address()->count() > 0) {
            $this->address->update($inputs);
        } else {
            $new_addr = Address::create($inputs);
            $this->update([
                'address_id' => $new_addr->id,
            ]);
        }
        return $this->address;
    }

    // Address Accessors

    public function getAddress1Attribute(): string
    {
    	$num = $this->address->street_number ?? '';
    	$name = $this->address->street_name ?? '';
    	return trim($num . ' ' . $name);
    }

    public function getAddress2Attribute(): string
    {
    	return $this->address->line_2 ?? '';
    }

    public function getLocalityAttribute(): string
    {
        return $this->address->locality ?? '';
    }

    // city - for backward compatibility
    public function getCityAttribute(): string
    {
    	return $this->locality;
    }

    public function getStateAttribute(): string
    {
	    return $this->address->state_abbr ?? '';
    }

    public function getPostalCodeAttribute(): string
    {
	    return $this->address->postal_code ?? '';
    }

    // zip - for backward compatibility
    public function getZipAttribute(): string
    {
    	return $this->postal_code;
    }

    public function getCountyAttribute(): string
    {
	    return $this->address->county->name ?? 'Unknown';
    }

    public function getLatitudeAttribute(): string
    {
    	return $this->address->latitude ?? '';
    }

	public function getLongitudeAttribute(): string
	{
		return $this->address->longitude ?? '';
	}
}
