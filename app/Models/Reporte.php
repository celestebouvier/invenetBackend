<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    public function usuario() {
    return $this->belongsTo(User::class, 'user_id');
}

    public function dispositivo() {
    return $this->belongsTo(Dispositivo::class);
}
}
