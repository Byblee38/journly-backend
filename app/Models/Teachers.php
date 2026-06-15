<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Teachers extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'teachers'; 
    protected $fillable = [
        'nip',
        'name',
        'birth_date',
        'gender',
        'position',
        'is_active'
    ];
}
