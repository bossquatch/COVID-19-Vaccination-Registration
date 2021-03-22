<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ShotRecord extends Model
{
    use HasFactory;

	protected $table = 'fl_shots';
	protected $primaryKey = 'id';

	public function registration(): HasOneThrough
	{
		return $this->hasOneThrough (Registration::class,RegistrationShot::class,'fl_shots_id','id','id','registration_id');
	}

}
