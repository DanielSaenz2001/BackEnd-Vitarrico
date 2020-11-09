<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ProductosDespachos extends Model{

    use HasFactory,Notifiable;

    public $timestamps = false;
    protected $guarded = ["id"];
    
    public function scopeName($query, $name){
        return $query->where('productos.nombre','like',"%$name%");
    }
}
