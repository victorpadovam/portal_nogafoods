<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutrosOpcao extends Model
{
    use HasFactory;

    protected $table = 'outros_opcoes';

    protected $fillable = [
        'store_id',
        'selecionada',
        'img',
        'titulo',
        'tipo',
        'pagamento_na_entrega_ativado',
        'pagamento_na_retirada_ativado',
    ];
}
