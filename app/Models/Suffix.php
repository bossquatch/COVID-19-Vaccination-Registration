<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suffix extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registrations() {
        return $this->hasMany(Registration::class, 'suffix_id');
    }

    public function users() {
        return $this->hasMany(Registration::class, 'suffix_id');
    }
}
