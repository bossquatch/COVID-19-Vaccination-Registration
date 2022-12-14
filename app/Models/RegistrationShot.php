<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationShot extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'fl_shots_registrations';

	public function registration(): HasOne
	{
		return $this->hasOne(Registration::class, 'registration_id','id');
	}
	public function shotRecord(): HasOne
	{
		return $this->hasOne (ShotRecord::class,'fl_shots_id','id');
	}

}
