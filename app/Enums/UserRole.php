<?php

namespace App\Enums;

enum UserRole :string
{
    case ADMIN = 'admin';
    case MENTOR = 'mentor';
    case SISWA = 'siswa';
}
