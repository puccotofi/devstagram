<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // improtante aqui para crear la relacion entre user y el post usaremos una llave foranea que sera el id
        // del usuario, para eso laravel usa los campos foreignId y luego en el nombre debe ser nombre de la tabla y _ el campo
        // tambien desde aqui se manejan las reglas para la integridad referencial.
        // para correr la migracion como siempre: sail artisan migrate
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
