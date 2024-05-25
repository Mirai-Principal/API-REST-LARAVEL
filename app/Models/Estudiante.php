<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiante';

    // protected $fillable = true;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'habilidad'
    ];
}
