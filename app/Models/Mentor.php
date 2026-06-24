<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    protected $table = 'mentors';
    protected $fillable = [
        'user_id',
        'identity_number',
        'name',
        'gender',
        'birth_date',
        'company_name',
        'position',
        'is_active'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
