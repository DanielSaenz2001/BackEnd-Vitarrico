<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class MateriasPrimas extends Model{

    use HasFactory,Notifiable;

    public $timestamps = false;
    protected $guarded = ["id"];
    
    public function scopeName($query, $name){
        return $query->where('materias_primas.nombre','like',"%$name%");
    }
}
