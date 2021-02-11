<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class,'id', 'user_id');
    }
    public function regsitration()
    {
        return $this->hasOne(Registration::class,'id','registration_id');
    }
}
