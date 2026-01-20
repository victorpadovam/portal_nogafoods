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
        Schema::create('credito_opcoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable();
            $table->boolean('selecionada')->nullable();
            $table->string('img')->nullable();
            $table->string('titulo')->nullable();
            $table->string('tipo')->nullable();
            $table->boolean('pagamento_na_entrega_ativado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credito_opcoes');
    }
};
