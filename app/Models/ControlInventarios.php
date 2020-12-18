<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlInventarios extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ["id"];
    public function scopeTipo($query, $tipo){
        return $query->where('control_inventarios.tipo','like',$tipo);
    }
    public function scopeEstado($query, $estado){
        return $query->where('control_inventarios.estado','like',$estado);
    }
    public function scopeUser($query, $user){
        return $query->where('control_inventarios.responsable','like',$user);
    }
    public function scopeUse($query, $user){
        return $query->where('control_inventarios.responsable','not like',$user);
    }
}
