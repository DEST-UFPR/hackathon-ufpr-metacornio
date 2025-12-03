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
        Schema::create('tabela_geral', function (Blueprint $table) {
            $table->id();
            $table->string("tipo_dado");
            $table->string("valor_dado");
            $table->string("descricao_dado");
            $table->integer("sequencia")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabela_geral');
    }
};
