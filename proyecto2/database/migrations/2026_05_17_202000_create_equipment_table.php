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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nullable = false por defecto
            $table->string('type');
            $table->text('description')->nullable(); // columnDefinition = "TEXT"
            $table->integer('stock');
            
            // Tu Enum de estados para el equipo (puedes ajustar los strings según tu EquipmentStatus de Java)
            // Ejemplo: ['DISPONIBLE', 'MANTENIMIENTO', 'DE BAJA', 'PRESTADO']
            // Busca la línea del status y déjala así:
            $table->enum('status', ['DISPONIBLE', 'OCUPADO', 'MANTENIMIENTO'])->default('DISPONIBLE');
            // Guarda el nombre del archivo. En Java no tenía restricción, así que puede ser nullable
            $table->string('image_filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
