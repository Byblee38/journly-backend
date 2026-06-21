<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportActivity extends Model
{
    protected $table = 'report_activity';
    protected $fillable = [
        'report_id',
        'title',
        'description',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
