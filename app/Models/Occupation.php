<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registrations() {
        return $this->hasMany(Registration::class, 'essential_worker_id');
    }
}
