<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $table = 'report';
    protected $fillable = [
        'student_id',
        'teacher_id',
        'report_date',
        'status',
        'mentor_note',
        'approved_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function reportActivities(): HasMany
    {
        return $this->hasMany(ReportActivity::class);
    }
}
