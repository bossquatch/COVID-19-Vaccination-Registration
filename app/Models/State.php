<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function address()
    {
        $this->belongsTo(Address::class);
    }

    public function counties()
	{
		return $this->hasMany(County::class);
	}

}
