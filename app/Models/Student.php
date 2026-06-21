<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'nisn',
        'user_id',
        'teacher_id',
        'name',
        'birth',
        'gender',
        'is_active',
        'class',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
