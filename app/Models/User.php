<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'sms_capable',
        'birth_date',
        'sms_verifed_at',
        'suffix_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return (bool)($this->sms_verified_at != null);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'sms_capable' => true,
            'sms_verified_at' => Carbon::now(),
        ])->save();
    }

    public function AuditLogs()
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    public function AuditChanges()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function registration()
    {
        return $this->hasOne(Registration::class, 'user_id');
    }

    // roles and permissions
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function assignRole($role)
    {
        // if a string is passed in grab the role object
        if(is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        $this->roles()->sync($role,false);
    }

    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    public function suffix()
    {
        return $this->belongsTo(Suffix::class, 'suffix_id');
    }

    public function needsToResetPassword() 
    {
        return ($this->force_reset && Carbon::parse($this->force_reset)->isAfter(Carbon::now()->add(-1, 'hours')));
    }

    public function removeForceReset() 
    {
        $this->force_reset = null;
        $this->save();
    }

    public function forceReset()
    {
        $this->force_reset = Carbon::now();
        $this->save();
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
