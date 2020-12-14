<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductosElaboraciones extends Model
{
    use HasFactory,Notifiable;

    public $timestamps = false;
    protected $guarded = ["id"];
}
