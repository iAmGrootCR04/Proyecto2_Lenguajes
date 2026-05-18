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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // @Id y @GeneratedValue(strategy = GenerationType.IDENTITY)
            $table->string('username')->unique(); // nullable = false por defecto en Laravel
            $table->string('password');
            $table->string('email')->unique();
            $table->string('role');
            $table->string('full_name'); // @Column(name = "full_name")
            $table->rememberToken(); // Recomendado para la autenticación en Laravel
            $table->timestamps(); // Añade 'created_at' y 'updated_at' (Súper útil en Laravel)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
