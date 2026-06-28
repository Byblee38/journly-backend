<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorToken extends Model
{
    protected $table = 'mentor_tokens';
    protected $fillable = [
        'token',
        'is_used',
    ];
}
