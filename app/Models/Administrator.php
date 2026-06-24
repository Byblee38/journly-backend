<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrator extends Model
{
    protected $table = "administrators";

    protected $fillable = [
        "user_id",
        "nip",
        "name",
        "birth_date",
        "gender",
        "position",
        "is_active"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


