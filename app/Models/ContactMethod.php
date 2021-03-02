<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function invitations() {
        return $this->hasMany(Invitation::class, 'contact_method_id');
    }
}
