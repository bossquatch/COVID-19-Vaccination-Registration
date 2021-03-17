<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccine extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function risk_factors()
    {
        return $this->belongsToMany(RiskFactor::class)->withTimestamps();
    }

    public function vaccine_type() {
        return $this->belongsTo(VaccineType::class, 'vaccine_type_id');
    }

    public function eligibility() {
        return $this->belongsTo(Eligibility::class, 'eligibility_id');
    }

    public function injection_route() {
        return $this->belongsTo(InjectionRoute::class, 'injection_route_id');
    }

    public function injection_site() {
        return $this->belongsTo(InjectionSite::class, 'injection_site_id');
    }

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }
}
