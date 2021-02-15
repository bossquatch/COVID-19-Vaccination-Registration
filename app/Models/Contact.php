<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function contact_type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function phone_type()
    {
        return $this->belongsTo(PhoneType::class, 'phone_type_id');
    }
}
