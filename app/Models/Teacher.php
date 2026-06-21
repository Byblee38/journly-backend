<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'gender',
        'position',
        'birth_date',
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
