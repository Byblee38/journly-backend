<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Students extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'students'; 
    protected $fillable = [
        'nisn',
        'name',
        'birth',
        'gender',
        'is_active',
        'class',
        'address'
    ];
}
