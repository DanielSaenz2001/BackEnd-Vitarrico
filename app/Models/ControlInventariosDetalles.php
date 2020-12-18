<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlInventariosDetalles extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ["id"];
    public function scopeEstado($query, $estado){
        return $query->where('control_inventarios_detalles.estado','like',$estado);
    }
}
