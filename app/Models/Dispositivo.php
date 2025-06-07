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
        'estado',
        'descripcion',
        'codigo_qr',
    ];


    public function reportes() {
    return $this->hasMany(Reporte::class);
    }

    public function marca() {
    return $this->belongsTo(Marca::class);
    }

    public function ordenes_reparacion() {
    return $this->hasMany(OrdenReparacion::class);
    }



}
