<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    private function addressType()
	{
		return $this->hasOne(AddressType::class);
	}

	private function registration()
	{
		return $this->belongsTo(Registration::class);
	}

}
