<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mercado_pago_config_lojistas', function (Blueprint $table) {
            $table->id()->autoIncrement();
             $table->boolean('cartao_ativado')->nullable();
            $table->boolean('pix_ativado')->nullable();
            $table->boolean('pagamento_digital_no_app_ativado');
            $table->text('access_token')->nullable();
            $table->text('public_key')->nullable();
            $table->integer('store_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mercado_pago_config_lojistas');
    }
};
