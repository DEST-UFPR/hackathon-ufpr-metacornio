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
        Schema::create('pesquisa_curso', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_avaliacao');
            $table->bigInteger('id_pesquisa');
            $table->bigInteger('id_questionario');
            $table->string('questionario');
            $table->bigInteger('id_pergunta');
            $table->longText('pergunta');
            $table->string('resposta');
            $table->string('situacao');
            $table->string('multipla_escolha');
            $table->string('cod_curso');
            $table->string('curso');
            $table->string('setor_curso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesquisa_curso');
    }
};
