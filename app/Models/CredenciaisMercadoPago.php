<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CredenciaisMercadoPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'token_type',
        'expires_in',
        'scope',
        'user_id',
        'refresh_token',
        'public_key',
        'live_mode',
        'state',
        'store_id',
    ];
}
