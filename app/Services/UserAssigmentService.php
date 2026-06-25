<?php

namespace App\Services;

use App\Models\Administrator;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\Teacher;

class UserAssigmentService
{
    public function getTargetModel(string $role)
    {
        $models = $this->targetModel();
        $cleanRole = strtolower($role);
        
        return $models[$cleanRole] ?? null;
    }

    public function targetModel()
    {
        return [
            'student' => [
                'model' => Student::class,
                'identity_type' => 'nisn'
            ],
            'teacher' => [
                'model' => Teacher::class,
                'identity_type' => 'nip'
            ],
            'mentor' => [
                'model' => Mentor::class,
                'identity_type' => 'identity_number'
            ],
            'administrator' => [
                'model' => Administrator::class,
                'identity_type' => 'nip'
            ],
        ];
    }
}
