<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'marca',
        'modelo',
        'nro_serie',
        'ubicacion',
        'descripcion',
    ];


    public function reportes() {
    return $this->hasMany(Reporte::class);
}
}
