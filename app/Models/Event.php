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
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function slots() {
        return $this->hasMany(Slot::class, 'event_id');
    }

    public function lots() {
        return $this->belongsToMany(Lot::class)->withTimestamps();
    }
}
