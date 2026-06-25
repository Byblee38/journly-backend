<?php

namespace App\Enums;

enum UserRole :string
{
    case ADMIN = 'administrator';
    case MENTOR = 'mentor';
    case STUDENT = 'student';
    case TEACHER = 'teacher';
}
