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
        Schema::create('import_pesquisa', function (Blueprint $table) {
            $table->id();
            $table->string("nome_usuario");
            $table->bigInteger('id_avaliacao');
            $table->string("caminho_arquivo");
            $table->string("nome_arquivo");
            $table->string("categoria_pesquisa");
            $table->string("ano_pesquisa");
            $table->json("dados_importacao")->nullable();
            $table->string("status_importacao");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_pesquisa');
    }
};
