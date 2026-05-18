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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            // Campos de tipo Fecha (LocalDate)
            $table->date('request_date'); 
            $table->date('start_date')->nullable(); // En Java no tenía nullable=false, así que puede ser null
            $table->date('estimated_end_date');
            $table->date('actual_return_date')->nullable(); // Puede ser null hasta que se devuelva
            
            // Campo de Texto largo (columnDefinition = "TEXT")
            $table->text('justification')->nullable(); 

            // Tu Enum de Java traducido a Enum de Base de Datos
         // Busca la línea del status y corrígela para que quede así:
           $table->enum('status', ['PENDIENTE', 'APROBADO', 'RECHAZADO', 'PRESTADO', 'DEVUELTO'])->default('PENDIENTE');

            // Claves foráneas (@JoinColumn)
            // foreignIdFor busca automáticamente el modelo y crea la columna 'equipment_id' y 'user_id'
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
