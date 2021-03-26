<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'email_replies';
    protected $primaryKey   = 'id';
	protected $dates        = [
		'date',
		'created_at',
		'updated_at',
		'deleted_at',
	];
    protected $appends      = [
        'email',
	    'topic',
	    'body',
	    'signature',
    ];

    public function registration(): BelongsTo
    {
    	return $this->belongsTo (Registration::class, 'registration_id');
    }

    public function GetTopicAttribute(): string
    {
    	return $this->subject ?? '';
    }
    public function GetBodyAttribute(): string
    {
    	return $this->stripped_text ?? '';
    }
    public function GetSignatureAttribute(): string
    {
    	return $this->stripped_signature ?? '';
    }

}
