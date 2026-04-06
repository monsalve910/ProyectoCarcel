<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prisionero_id')->constrained('prisioneros')->onDelete('restrict');
            $table->foreignId('visitante_id')->constrained('visitantes')->onDelete('restrict');
            $table->foreignId('guardia_id')->constrained('users')->onDelete('restrict');
            $table->dateTime('fecha_hora_entrada');
            $table->dateTime('fecha_hora_salida');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'completada', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index(['prisionero_id', 'fecha_hora_entrada', 'fecha_hora_salida']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
