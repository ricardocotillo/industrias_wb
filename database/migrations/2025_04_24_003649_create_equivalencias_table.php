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
        Schema::create('equivalencias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->string('codigo_alt', 50)->nullable();
            $table->string('marca', 25);
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['codigo', 'marca', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalencias');
    }
};
