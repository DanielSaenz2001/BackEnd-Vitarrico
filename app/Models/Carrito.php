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
        error_log('Estoy siendo filtrado 1.0');
        return $query->where('carritos.tipo','like',$tipo);
    }
    public function scopeUser($query, $user){
        error_log('Estoy siendo filtrado 2.0');
        return $query->where('carritos.user_id','like',$user);
    }
}
