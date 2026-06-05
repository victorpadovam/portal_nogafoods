<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluxoAprovacaoLoja extends Model
{
    use HasFactory;

    protected $table = 'fluxo_aprovacao_lojas';

    protected $fillable = [
        'id',
        'tipo'
    ];
}