<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentoMercadoPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'payment_id',
        'valor',
        'status',
        'user_id',
        'order_id',
        'venda_id',
    ];
}
