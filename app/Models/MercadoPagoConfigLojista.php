<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercadoPagoConfigLojista extends Model
{
    use HasFactory;
    
    protected $table = 'mercado_pago_config_lojistas';


    protected $fillable = [
        'pix_ativado',
        'cartao_ativado',
        'pagamento_digital_no_app_ativado',
        'access_token',
        'public_key',
        'store_id',
    ];
}
