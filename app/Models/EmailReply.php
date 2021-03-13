<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'email_replies';
    protected $primaryKey   = 'id';

}
