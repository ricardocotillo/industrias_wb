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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 25)->unique();
            $table->string('codigo_alt', 25)->nullable();
            $table->string('linea', 25)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->text('aplicaciones')->nullable();
            $table->string('diametro_exterior', 50)->nullable();
            $table->string('diametro_interior', 50)->nullable();
            $table->decimal('altura', 8, 2)->nullable();
            $table->unsignedInteger('pzs_x_caja')->nullable();
            $table->enum('valv_antidr', ['si', 'no'])->nullable();
            $table->enum('valv_by_pass', ['si', 'no'])->nullable();
            $table->text('descripcion')->nullable();
            $table->string('empaquetadura', 25)->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('promocion')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
