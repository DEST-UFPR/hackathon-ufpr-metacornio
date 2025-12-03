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
        Schema::create('pesquisa_institucional', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_avaliacao');
            $table->bigInteger('id_pesquisa');
            $table->bigInteger('id_questionario');
            $table->string('questionario');
            $table->bigInteger('id_pergunta');
            $table->longText('pergunta');
            $table->string('resposta');
            $table->string('situacao');
            $table->string('sigla_lotacao');
            $table->string('lotacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesquisa_institucional');
    }
};
