<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

	protected $guarded = [];

    public function addressType()
	{
		return $this->hasOne(AddressType::class, 'id', 'address_type_id');
	}

	public function registration(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(Registration::class, 'address_id', 'id');
	}

	public function state()
	{
		return $this->hasOne(State::class, 'id', 'state_id');
	}

	public function county()
	{
		return $this->hasOne(County::class, 'id', 'county_id');
	}

	// define some accessors to make this easier to use

	public function getFormattedAddressAttribute()
	{
		$fAddress = $this->street_number . ' ' . $this->street_name . ', ' . $this->locality . ', ' . $this->state->abbr . ' ' . $this->postal_code;
		return $fAddress;
	}

	public function getCityAttribute()
	{
		return $this->locality;
	}
	public function getStateNameAttribute()
	{
		return $this->state->name;
	}
	public function getStateAbbrAttribute()
	{
		return $this->state->abbr;
	}
	public function getZipCodeAttribute()
	{
		return $this->postal_code;
	}

}
