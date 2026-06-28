<?php

namespace App\Services;

use App\Models\User;

class ReportService
{
    public function hasTodayReport(User $user, string $date)
    {
        $hasReport = $user->student->report()->where('report_date', $date)->exists();
        return $hasReport ? true : false;
    }

    public function hasTeacher(User $user){
        $teacher = $user->student->teacher;
        return $teacher ? true : false;
    }

    public function hasApprove(User $user){
        $approve = $user->student->report->status;
        return $approve !== 'pending' ? true : false;
    }
}