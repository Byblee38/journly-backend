<?php

namespace App;

enum UserRole :string
{
    case ADMIN = 'admin';
    case MENTOR = 'mentor';
    case SISWA = 'siswa';
}
