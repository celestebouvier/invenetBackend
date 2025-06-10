<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{

    protected $fillable = ['user_id', 'dispositivo_id', 'descripcion', 'estado'];


    public function usuario() {
    return $this->belongsTo(User::class, 'user_id');
}

    public function dispositivo() {
    return $this->belongsTo(Dispositivo::class);
}
}
