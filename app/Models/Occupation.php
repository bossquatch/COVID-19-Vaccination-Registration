<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function registrations() {
        return $this->hasMany(Registration::class, 'occupation_id');
    }
}
