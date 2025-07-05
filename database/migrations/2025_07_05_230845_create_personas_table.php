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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono');
            $table->string('direccion');
            $table->unsignedBigInteger('id_tipo_identificacion');
            $table->timestamps();

            $table->foreign('id_tipo_identificacion')->references('id_tipo_identificacion')->on('tipo_documentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
