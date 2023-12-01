<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }*/
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });
        DB::table('roles')->insert([
            ['nombre' => 'Administrador'],
            ['nombre' => 'Usuario'],
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles');
            
        });
        $pass= Hash::make('11111111');
        $rolid=1;
        DB::table('users')->insert([
            ['name' => 'Herlan',
            'email' => 'herlan@gmail.com',
            'password' => $pass,
            'rol_id' => $rolid,]
        ]);
        Schema::create('docentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('telefono');
            $table->string('correo')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::create('carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });
        DB::table('carreras')->insert([
            ['nombre' => 'Informatica'],
            ['nombre' => 'Sistemas Electronicos'],
            ['nombre' => 'Diseño Grafico'],
            ['nombre' => 'Energias Renovables'],
            ['nombre' => 'Construccion Civil'],
        ]);

        Schema::create('semestres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->integer('carrera_id')->unsigned();
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade');
        });
        $carreras = DB::table('carreras')->get();
        foreach ($carreras as $carrera) {
            for ($i = 1; $i <= 6; $i++) {
                DB::table('semestres')->insert([
                    'nombre' => $i . '° Semestre de la carrera: ' . $carrera->nombre,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'carrera_id' => $carrera->id,
                ]);
            }
        }
        Schema::create('materias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
            $table->integer('docente_id')->nullable()->unsigned();
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('set null');
            $table->integer('semestre_id')->unsigned();
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');;
        });
        $semestreid = 4;
        DB::table('materias')->insert([
            ['nombre' => 'SOPORTE TECNICO DE REDES',
            'semestre_id'=>$semestreid],
            ['nombre' => 'BASE DE DATOS GEOGRAFICA',
            'semestre_id'=>$semestreid],
            ['nombre' => 'ADMINISTRACION DE SERVIDORES I',
            'semestre_id'=>$semestreid],
            ['nombre' => 'PROGRAMACION FRONT END WEB',
            'semestre_id'=>$semestreid],
            ['nombre' => 'SOPORTE TECNICO EN APLICACIONES',
            'semestre_id'=>$semestreid],
        ]);
        
        
        Schema::create('horarios', function(blueprint $table){
            $table->increments('id');
            $table->time('hora_inicio',0);
            $table->time('hora_fin',0);
            $table->timestamps();
        });
        DB::table('horarios')->insert([
            ['hora_inicio' => '17:30',
            'hora_fin' => '18:15'],
            ['hora_inicio' => '18:15',
            'hora_fin' => '19:00'],
            ['hora_inicio' => '19:00',
            'hora_fin' => '19:45'],
            ['hora_inicio' => '19:55',
            'hora_fin' => '20:40'],
            ['hora_inicio' => '20:40',
            'hora_fin' => '21:35'],
            ['hora_inicio' => '21:35',
            'hora_fin' => '22:10'],
        ]);
        Schema::create('laboratorios', function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });
        DB::table('laboratorios')->insert([
            ['nombre' => 'Laboratorio informatica'],
            ['nombre' => 'Laboratorio lanza'],
        ]);
        Schema::create('periodos', function (Blueprint $table){
            $table->increments('id');
            $table->string('dia');
            $table->timestamps();
            $table->integer('materia_id')->unsigned();
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->integer('horario_id')->unsigned();
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
            $table->integer('laboratorio_id')->nullable()->unsigned();
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('set null');;
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
        Schema::dropIfExists('laboratorios');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('carreras');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
