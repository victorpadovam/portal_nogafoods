<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FluxoAprovacaoLoja;
use App\Models\Store;


class FluxoAprovacaoLojaController extends Controller
{
    public function buscar()
    {
        $fluxo = FluxoAprovacaoLoja::first();

        return response()->json([
            'tipo' => $fluxo->tipo ?? null
        ]);
    }
    public function salvar(Request $request)
    {

        FluxoAprovacaoLoja::updateOrCreate(
            ['id' => 1],
            ['tipo' => $request->tipo]
        );

        return response()->json(['success' => true]);
    }

    public function aprovar(Request $request)
    {
        $store = Store::find($request->store_id);

        if (!$store) {
            return response()->json(['success' => false]);
        }

        $store->status_de_aprovacao = 'aprovado';
        $store->save();

        return response()->json(['success' => true]);
    }

    public function verificarStatusPorEmail(Request $request)
    {

        $store = Store::where('email', $request->email)->first();

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Loja não encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'status_de_aprovacao' => $store->status_de_aprovacao
        ]);
    }
}
