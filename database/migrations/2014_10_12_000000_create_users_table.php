<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('rol');
            $table->string('area');
            $table->string('dni')->unique();
            $table->boolean('autorizado');
            $table->string('imagen_user');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'name' => "Daniel Andrés Sáenz Shupingahua",
            'email' => "daniel.saenz@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Administrador",
            'rol' => "Administrador",
            'dni'=> "70444029",
            'autorizado' => 1,
            'imagen_user' => "https://cdn3.iconfinder.com/data/icons/avatars-round-flat/33/avat-01-512.png",
        ]);
        DB::table('users')->insert([
            'name' => "Godofredo Quea",
            'email' => "godofredo.quea@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Jefe",
            'rol' => "Jefe de Area",
            'dni'=> "70444021",
            'autorizado' => 1,
            'imagen_user' => "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png",
        ]);
        DB::table('users')->insert([
            'name' => "Fernando Chura",
            'email' => "fernando.chura@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Jefe",
            'rol' => "Jefe de Almacen",
            'dni'=> "70444025",
            'autorizado' => 1,
            'imagen_user' => "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png",
        ]);
        DB::table('users')->insert([
            'name' => "Waldir Quillimamani",
            'email' => "waldir.quillimamani@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Jefe",
            'rol' => "Empleado",
            'dni'=> "70444020",
            'autorizado' => 1,
            'imagen_user' => "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png",
        ]);
        DB::table('users')->insert([
            'name' => "Waldir Quillimamani",
            'email' => "waldir.quillimamani@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Jefe",
            'rol' => "Empleado",
            'dni'=> "70444020",
            'autorizado' => 1,
            'imagen_user' => "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png",
        ]);
        DB::table('users')->insert([
            'name' => "Jhon Carita",
            'email' => "jhon.carita@upeu.edu.pe",
            'password' => bcrypt('password'),
            'area' => "Administrador",
            'rol' => "Administrador",
            'dni'=> "60444020",
            'autorizado' => 1,
            'imagen_user' => "https://cdn3.iconfinder.com/data/icons/avatars-round-flat/33/avat-01-512.png",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
