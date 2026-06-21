<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;

class UserController extends Controller
{
    public function getTeachers() {
        $teachers = Teacher::whereNotNull('user_id')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data teachers berhasil diambil',
            'data' => $teachers
        ]);
    }

    public function getStudents() {
        $students = Student::whereNotNull('user_id')->get();
        $data = $students->map(function($item) {
            return [
                'id' => $item->id,
                'teacher_id' => $item->teacher_id,
                'user_id' => $item->user_id,
                'nisn' => $item->nisn,
                'name' => $item->name,
            ];
        });
        return response()->json([
            'success' => true,
            'message' => 'Data students berhasil diambil',
            'data' => $data,
        ]);
    }
}
