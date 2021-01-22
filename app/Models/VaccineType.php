<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineType extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function vaccines() {
        return $this->hasMany(Vaccine::class, 'vaccine_type_id');
    }
}
