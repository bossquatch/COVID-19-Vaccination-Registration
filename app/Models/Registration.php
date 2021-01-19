<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function AuditLogs()
    {
        return $this->hasMany(AuditLog::class, 'regis_id');
    }

    public function AuditChanges()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'registration_id');
    }

    public function emails()
    {
        return $this->contacts()->where('contact_type_id', 1)->get();
    }

    public function phones()
    {
        return $this->contacts()->where('contact_type_id', 2)->get();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function race()
    {
        return $this->belongsTo(Race::class, 'race_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function suffix()
    {
        return $this->belongsTo(Suffix::class, 'suffix_id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }

    public function conditions()
    {
        return $this->belongsToMany(Condition::class)->withTimestamps();
    }

    public function vaccines() {
        return $this->hasMany(Vaccine::class, 'registration_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'registration_id');
    }

    public function hasComments() {
        if ($this->comments()->count() > 0) {
            return true;
        }
        return false;
    }
}
