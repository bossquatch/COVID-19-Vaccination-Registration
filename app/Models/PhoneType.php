<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contacts() {
        return $this->hasMany(Contact::class, 'phone_type_id');
    }
}
