<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenReparacion extends Model
{
    protected $fillable = ['reporte_id', 'tecnico_id', 'detalles', 'completada'];

public function reporte()
{
    return $this->belongsTo(Reporte::class);
}

public function tecnico()
{
    return $this->belongsTo(User::class, 'tecnico_id');
}
}
