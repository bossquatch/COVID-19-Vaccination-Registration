<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventMessage extends Model
{
    use HasFactory, SoftDeletes;

    public function Event(): HasOne
    {
    	return $this->hasOne (Event::class,'event_id');
    }
}
