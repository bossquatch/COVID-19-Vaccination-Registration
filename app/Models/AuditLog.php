<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $dates = [
    	'created_at',
	    'updated_at',
    	'deleted_at',
    ];
    protected $appends = [
    	'model',
	    'activeUser'
    ]
;
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'regis_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function auditable()
    {
        return $this->morphTo();
    }

    public function getDateCreatedAttribute(): string
    {
    	return Carbon::parse($this->created_at)->format('m-d-Y H:i:s A');
    }

    public function getModelAttribute(): string
    {
    	$model = str_replace ('App\\Models\\', '', $this->auditable_type);
    	return $model;
    }

    public function getActiveUserAttribute(): string
    {


    	return $this->user->name == $this->registration->name ? 'Self' : $this->user->name ?? '';
    }

}
