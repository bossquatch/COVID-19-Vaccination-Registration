<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function AuditChanges()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    public function registration() {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
