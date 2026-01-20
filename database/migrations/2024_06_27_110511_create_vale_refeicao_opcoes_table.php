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
        Schema::create('vale_refeicao_opcoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable();
            $table->boolean('selecionada')->nullable();
            $table->string('img')->nullable();
            $table->string('titulo')->nullable();
            $table->string('tipo')->nullable();
            $table->boolean('pagamento_na_entrega_ativado')->nullable();
            $table->boolean('pagamento_na_retirada_ativado')->nullable();
            $table->timestamps();
        });

        // Inserir dados iniciais
        DB::table('vale_refeicao_opcoes')->insert([
            [
                'store_id' => 24, 
                'selecionada' => true,
                'img' => 'Alelo_img',
                'titulo' => 'Vale Alelo',
                'tipo' => 'pagamento_na_entrega',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 24, 
                'selecionada' => true,
                'img' => 'Sodexo_img',
                'titulo' => 'Vale Sodexo',
                'tipo' => 'pagamento_na_entrega',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 24, 
                'selecionada' => true,
                'img' => 'Ticket_img',
                'titulo' => 'Vale Ticket',
                'tipo' => 'pagamento_na_entrega',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vale_refeicao_opcoes');
    }
};
