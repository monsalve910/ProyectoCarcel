<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prisioneros', function (Blueprint $table) {
            $table->id();
            $table->string('numero_celda', 20);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('numero_identificacion', 50)->unique();
            $table->date('fecha_nacimiento');
            $table->text('delito');
            $table->date('fecha_ingreso');
            $table->date('fecha_salida_prevista')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prisioneros');
    }
};
