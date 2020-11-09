<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class MaterialesEmpaques extends Model{

    use HasFactory,Notifiable;

    public $timestamps = false;
    protected $guarded = ["id"];
    
    public function scopeName($query, $name){
        return $query->where('materiales_empaques.nombre','like',"%$name%");
    }
}
