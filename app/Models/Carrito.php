<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ["id"];
    public function scopeTipo($query, $tipo){
        return $query->where('carritos.tipo','like',$tipo);
    }
    public function scopeUser($query, $user){
        return $query->where('carritos.user_id','like',$user);
    }
    public function scopeProducto($query, $producto){
        return $query->where('carritos.producto_id','like',$producto);
    }
    public function scopePrima($query, $prima){
        return $query->where('carritos.materias_primas_id','like',$prima);
    }
    public function scopeEmpaque($query, $empaque){
        return $query->where('carritos.empaque_id','like',$empaque);
    }

    public function scopePro($query){
        return $query->where('carritos.producto_id','like',"%%");
    }
    public function scopePri($query){
        return $query->where('carritos.materias_primas_id','like',"%%");
    }
    public function scopeEmp($query){
        return $query->where('carritos.empaque_id','like',"%%");
    }
}
