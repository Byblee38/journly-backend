<?php 

namespace App\Services;


use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Mentor;
use App\Models\Student;

class UserAssigmentService {
    public function getTargetModel(string $role) {
        return match (strtolower($role)) {
            'siswa', 'student' => [
                'model'    => Student::class, 
                'id_field' => 'nisn'
            ],
            'guru', 'teacher'  => [
                'model'    => Teacher::class, 
                'id_field' => 'nip'
            ],
            'mentor'           => [
                'model'    => Mentor::class,  
                'id_field' => 'identity_number'
            ],
            'admin'            => [
                'model'    => Admin::class,   
                'id_field' => 'identity_number'
            ],
            default            => null
        };
    }
}
