<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function address() {
        return $this->belongsToMany(Address::class);
    }

    public function state()
	{
		return $this->hasOne(State::class, 'id', 'state_id');
	}
}
