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
        Schema::create('pergunta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_avaliacao');
            $table->bigInteger('id_questionario');
            $table->string('categoria_pergunta');
            $table->integer('ordem_pergunta');
            $table->string('tipo_pergunta');
            $table->longText('texto_pergunta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pergunta');
    }
};
