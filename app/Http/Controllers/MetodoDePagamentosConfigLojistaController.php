<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisbursementWithdrawalMethod;
use App\CentralLogics\Helpers;
use App\Models\WithdrawalMethod;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use App\Models\MercadoPagoConfigLojista;
use App\Models\ValeRefeicaoOpcao;
use App\Models\DebitoOpcoes;
use App\Models\CreditoOpcao;
use App\Models\OutrosOpcao;


use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class MetodoDePagamentosConfigLojistaController extends Controller
{
    public function index(Request $request)
    {
        // 1 -
        $this->inicializaDadosLojaLogadaStoreID();

        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $findDadosConfigMP = MercadoPagoConfigLojista::where('store_id', $buscaALoja->id)->first();

        //Buscas - PagamentoNaEntregaAtivado
        $findDadosValeAlimentacaoPgEntregaAtivado = ValeRefeicaoOpcao::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_entrega')->first();
        $findDadosDebitoPgEntrega = DebitoOpcoes::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_entrega')->first();
        //

        //Buscas - PagamentoNaRetriadaAtivado
        $findDadosValeAlimentacaoPgRetiradaAtivado = ValeRefeicaoOpcao::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_retirada')->first();
        $findDadosDebitoPgRetirada = DebitoOpcoes::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_retirada')->first();
        //


        // 2 -  PagamentoNaEntrega
        $refeicaoPagamentoNaEntrega = $this->tratamentoPgEntregaValeRefeicao();
        $debitoPgEntrega = $this->tratamentoPgEntregaDebitoOpcoeos();
        $creditoPgEntrega = $this->tratamentoPgEntregaCreditoOpcoeos();
        $outrosPgEntrega = $this->tratamentoPgEntregaOutrosOpcoeos();

        // 3 -  PagamentoNaRetirada
        $refeicaoPagamentoNaRefeicao = $this->tratamentoPgRetiradaValeRefeicao();
        $debitoPgRetirada = $this->tratamentoPgRetiradaDebitoOpcoeos();
        $creditoPagamentoNaRetirada = $this->tratamentoPgRetiradaCreditoOpcoeos();
        $outrosPgRetirada = $this->tratamentoPgRetiradaOutrosOpcoeos();


        return view('vendor-views.metodo_de_pagamento.index', compact(
            'idVendedor',
            'outrosPgRetirada',
            'creditoPagamentoNaRetirada',
            'debitoPgRetirada',
            'refeicaoPagamentoNaRefeicao',
            'findDadosValeAlimentacaoPgRetiradaAtivado',
            'findDadosDebitoPgRetirada',
            'findDadosConfigMP',
            'findDadosValeAlimentacaoPgEntregaAtivado',
            'refeicaoPagamentoNaEntrega',
            'findDadosDebitoPgEntrega',
            'debitoPgEntrega',
            'creditoPgEntrega',
            'outrosPgEntrega',
        ));
    }


    public function inicializaDadosLojaLogadaStoreID() {
        //PagamentoDigitalNoApp
        $this->criaDadosInicializadasPagamentoDigitalNoApp();
        //PagamentoNaEntrega
        $this->criaDadosInicializadasValeRefeicaoPagamentoNaEntrega(); //ValeRefeicao
        $this->criaDadosInicializadasDebitoPagamentoNaEntrega(); //Debitos
        $this->criaDadosInicializadasCreditoPagamentoNaEntrega(); //Credito
        $this->criaDadosInicializadasOutrosPagamentoNaEntrega(); //Outros

        //PagamentoNaRetirada
        $this->criaDadosInicializadasValeRefeicaoPagamentoNaRetirada(); //ValeRefeicao
        $this->criaDadosInicializadasDebitoPagamentoNaRetirada(); //Debitos
        $this->criaDadosInicializadasCreditoPagamentoNaRetirada(); //Credito
        $this->criaDadosInicializadasOutrosPagamentoNaRetirada(); //Outros

    }
    
    public function criaDadosInicializadasPagamentoDigitalNoApp() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = MercadoPagoConfigLojista::where('pagamento_digital_no_app_ativado', '1')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $mpConfig = new MercadoPagoConfigLojista();
            $mpConfig->pix_ativado = true;
            $mpConfig->store_id = $storeID;
            $mpConfig->cartao_ativado = true;
            $mpConfig->access_token = "";
            $mpConfig->public_key = "";
            $mpConfig->pagamento_digital_no_app_ativado = 1; //true
            $mpConfig->save();
        }
    }

    public function criaDadosInicializadasOutrosPagamentoNaRetirada() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao para copy paste
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = OutrosOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $buscaOpcoesEnquantoStoreIdENull = OutrosOpcao::where('tipo', 'pagamento_na_retirada')
                ->whereNull('store_id')
                ->get();

            foreach ($buscaOpcoesEnquantoStoreIdENull as $dados) {
                $buscaOpcoesEnquantoStoreIdENull = new OutrosOpcao();
                $buscaOpcoesEnquantoStoreIdENull->tipo = $dados->tipo;
                $buscaOpcoesEnquantoStoreIdENull->store_id = $storeID; //Salva padrao para o novo logado
                $buscaOpcoesEnquantoStoreIdENull->img = $dados->img;
                $buscaOpcoesEnquantoStoreIdENull->titulo = $dados->titulo;
                $buscaOpcoesEnquantoStoreIdENull->selecionada = 1;
                $buscaOpcoesEnquantoStoreIdENull->pagamento_na_retirada_ativado = 1; //true
                $buscaOpcoesEnquantoStoreIdENull->pagamento_na_entrega_ativado = 0; //false
                $buscaOpcoesEnquantoStoreIdENull->save();
            }
        }
    }

    public function criaDadosInicializadasCreditoPagamentoNaRetirada() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = CreditoOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $valeRefeicaoExistenteDados = CreditoOpcao::where('tipo', 'pagamento_na_retirada')
                ->whereNull('store_id')
                ->get();

            foreach ($valeRefeicaoExistenteDados as $dados) {
                $novoValeRefeicaoOpcao = new CreditoOpcao();
                $novoValeRefeicaoOpcao->tipo = $dados->tipo;
                $novoValeRefeicaoOpcao->store_id = $storeID; //Salva padrao para o novo logado
                $novoValeRefeicaoOpcao->img = $dados->img;
                $novoValeRefeicaoOpcao->titulo = $dados->titulo;
                $novoValeRefeicaoOpcao->selecionada = 1;
                $novoValeRefeicaoOpcao->pagamento_na_retirada_ativado = 1; //true
                $novoValeRefeicaoOpcao->pagamento_na_entrega_ativado = 0; //false
                $novoValeRefeicaoOpcao->save();
            }
        }
    }

    public function criaDadosInicializadasDebitoPagamentoNaRetirada() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = DebitoOpcoes::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $valeRefeicaoExistenteDados = DebitoOpcoes::where('tipo', 'pagamento_na_retirada')
                ->whereNull('store_id')
                ->get();

            foreach ($valeRefeicaoExistenteDados as $dados) {
                $novoValeRefeicaoOpcao = new DebitoOpcoes();
                $novoValeRefeicaoOpcao->tipo = $dados->tipo;
                $novoValeRefeicaoOpcao->store_id = $storeID; //Salva padrao para o novo logado
                $novoValeRefeicaoOpcao->img = $dados->img;
                $novoValeRefeicaoOpcao->titulo = $dados->titulo;
                $novoValeRefeicaoOpcao->selecionada = 1;
                $novoValeRefeicaoOpcao->pagamento_na_retirada_ativado = 1; //true
                $novoValeRefeicaoOpcao->pagamento_na_entrega_ativado = 0; //false
                $novoValeRefeicaoOpcao->save();
            }
        }
    }

    public function criaDadosInicializadasValeRefeicaoPagamentoNaRetirada() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $valeRefeicaoExistenteDados = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')
                ->whereNull('store_id')
                ->get();

            foreach ($valeRefeicaoExistenteDados as $dados) {
                $novoValeRefeicaoOpcao = new ValeRefeicaoOpcao();
                $novoValeRefeicaoOpcao->tipo = $dados->tipo;
                $novoValeRefeicaoOpcao->store_id = $storeID; //Salva padrao para o novo logado
                $novoValeRefeicaoOpcao->img = $dados->img;
                $novoValeRefeicaoOpcao->titulo = $dados->titulo;
                $novoValeRefeicaoOpcao->selecionada = 1;
                $novoValeRefeicaoOpcao->pagamento_na_retirada_ativado = 1; //true
                $novoValeRefeicaoOpcao->pagamento_na_entrega_ativado = 0; //false
                $novoValeRefeicaoOpcao->save();
            }
        }
    }

    public function criaDadosInicializadasValeRefeicaoPagamentoNaEntrega() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $valeRefeicaoExistenteDados = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')
                ->whereNull('store_id')
                ->get();

            foreach ($valeRefeicaoExistenteDados as $dados) {
                $novoValeRefeicaoOpcao = new ValeRefeicaoOpcao();
                $novoValeRefeicaoOpcao->tipo = $dados->tipo;
                $novoValeRefeicaoOpcao->store_id = $storeID; //Salva padrao para o novo logado
                $novoValeRefeicaoOpcao->img = $dados->img;
                $novoValeRefeicaoOpcao->titulo = $dados->titulo;
                $novoValeRefeicaoOpcao->selecionada = 1;
                $novoValeRefeicaoOpcao->pagamento_na_entrega_ativado = 1; //true
                $novoValeRefeicaoOpcao->save();
            }
        }
    }

    public function criaDadosInicializadasDebitoPagamentoNaEntrega() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao para copy paste
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = DebitoOpcoes::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $buscaOpcoesEnquantoStoreIdENull = DebitoOpcoes::where('tipo', 'pagamento_na_entrega')
                ->whereNull('store_id')
                ->get();

            foreach ($buscaOpcoesEnquantoStoreIdENull as $dados) {
                $novoDebitoStoreID = new DebitoOpcoes();
                $novoDebitoStoreID->tipo = $dados->tipo;
                $novoDebitoStoreID->store_id = $storeID; //Salva padrao para o novo logado
                $novoDebitoStoreID->img = $dados->img;
                $novoDebitoStoreID->titulo = $dados->titulo;
                $novoDebitoStoreID->selecionada = 1;
                $novoDebitoStoreID->pagamento_na_entrega_ativado = 1; //true
                $novoDebitoStoreID->save();
            }
        }
    }

    public function criaDadosInicializadasOutrosPagamentoNaEntrega() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao para copy paste
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = CreditoOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $buscaOpcoesEnquantoStoreIdENull = CreditoOpcao::where('tipo', 'pagamento_na_entrega')
                ->whereNull('store_id')
                ->get();

            foreach ($buscaOpcoesEnquantoStoreIdENull as $dados) {
                $novo = new CreditoOpcao();
                $novo->tipo = $dados->tipo;
                $novo->store_id = $storeID; //Salva padrao para o novo logado
                $novo->img = $dados->img;
                $novo->titulo = $dados->titulo;
                $novo->selecionada = 1;
                $novo->pagamento_na_entrega_ativado = 1; //true
                $novo->save();
            }
        }
    }


    public function criaDadosInicializadasCreditoPagamentoNaEntrega() {
        //Cria dados inicializados para o Store_id logado
        //Enquanto os store_id == null é base padrao para copy paste
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        $existeDados = OutrosOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->exists();

        if (!$existeDados) {
            $buscaOpcoesEnquantoStoreIdENull = OutrosOpcao::where('tipo', 'pagamento_na_entrega')
                ->whereNull('store_id')
                ->get();

            foreach ($buscaOpcoesEnquantoStoreIdENull as $dados) {
                $novo = new OutrosOpcao();
                $novo->tipo = $dados->tipo;
                $novo->store_id = $storeID; //Salva padrao para o novo logado
                $novo->img = $dados->img;
                $novo->titulo = $dados->titulo;
                $novo->selecionada = 1;
                $novo->pagamento_na_entrega_ativado = 1; //true
                $novo->save();
            }
        }
    }

    public function updateOrCreate(Request $request)
    {
        $this->salvaMercadoPagoConfigLojista($request);
        //PagamentoNaEntrega
        $this->salvaValeRefeicaoPagamentoNaEntrega($request); //Vale
        $this->salvaDebtitoPagamentoNaEntrega($request); //Debito
        $this->salvaCreditoPagamentoNaEntrega($request); //Credito
        $this->salvaOutrosPagamentoNaEntrega($request); //Outros

        //PagamentoNaRetirada
        $this->salvaValeRefeicaoPagamentoNaRetirada($request); //Vale
        $this->salvaDebtitoPagamentoNaRetirada($request); //Debito
        $this->salvaCreditoPagamentoNaRetirada($request); //Credito
        $this->salvaOutrosPagamentoNaRetirada($request); //Outros

        return back();
    }

    public function salvaOutrosPagamentoNaRetirada(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_retirada_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        OutrosOpcao::where('tipo', 'pagamento_na_retirada')->where('store_id', $storeID)
        ->update(['pagamento_na_retirada_ativado' => $valeRefeicaoAtivado]);

        $opcoes = OutrosOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['outros_pg_retirada'])) {
            $valeRefeicaoIDs = $data['outros_pg_retirada'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $valeRefeicaoIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = OutrosOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaValeRefeicaoPagamentoNaRetirada(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_retirada_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;
        // Atualiza o campo 'pagamento_na_retirada_ativado' para todas as opções relevantes
        ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')->where('store_id', $storeID)
        ->update(['pagamento_na_retirada_ativado' => $valeRefeicaoAtivado]);

        $opcoes = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['vale_refeicao_opcoes_pg_retirada'])) {
            $valeRefeicaoIDs = $data['vale_refeicao_opcoes_pg_retirada'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $valeRefeicaoIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = ValeRefeicaoOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaValeRefeicaoPagamentoNaEntrega(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_entrega_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        // Atualiza o campo 'pagamento_na_entrega_ativado' para todas as opções relevantes
        ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')->where('store_id', $storeID)
        ->update(['pagamento_na_entrega_ativado' => $valeRefeicaoAtivado]);

        $opcoes = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['vale_refeicao_opcoes_pg_entrega'])) {
            $valeRefeicaoIDs = $data['vale_refeicao_opcoes_pg_entrega'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $valeRefeicaoIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = ValeRefeicaoOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }

    }

    public function salvaDebtitoPagamentoNaRetirada(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_retirada_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        DebitoOpcoes::where('tipo', 'pagamento_na_retirada')->where('store_id', $storeID)
        ->update(['pagamento_na_retirada_ativado' => $valeRefeicaoAtivado]);

        $opcoes = DebitoOpcoes::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['debito_opcoes_pg_retirada'])) {
            $debitoIDs = $data['debito_opcoes_pg_retirada'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $debitoIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = DebitoOpcoes::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaDebtitoPagamentoNaEntrega(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_entrega_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        // Atualiza o campo 'pagamento_na_entrega_ativado' para todas as opções relevantes
        DebitoOpcoes::where('tipo', 'pagamento_na_entrega')->where('store_id', $storeID)
        ->update(['pagamento_na_entrega_ativado' => $valeRefeicaoAtivado]);

        $opcoes = DebitoOpcoes::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['debito_opcoes_pg_entrega'])) {
            $debitoIDs = $data['debito_opcoes_pg_entrega'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $debitoIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = DebitoOpcoes::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }


    public function salvaOutrosPagamentoNaEntrega(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_entrega_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        // Atualiza o campo 'pagamento_na_entrega_ativado' para todas as opções relevantes
        OutrosOpcao::where('tipo', 'pagamento_na_entrega')->where('store_id', $storeID)
        ->update(['pagamento_na_entrega_ativado' => $valeRefeicaoAtivado]);

        $opcoes = OutrosOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['outros_pg_entrega'])) {
            $outrosIDs = $data['outros_pg_entrega'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $outrosIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = OutrosOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaCreditoPagamentoNaEntrega(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_entrega_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        // Atualiza o campo 'retirada' para todas as opções relevantes
        CreditoOpcao::where('tipo', 'pagamento_na_entrega')->where('store_id', $storeID)
        ->update(['pagamento_na_entrega_ativado' => $valeRefeicaoAtivado]);

        $opcoes = CreditoOpcao::where('tipo', 'pagamento_na_entrega')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['credito_pg_entrega'])) {
            $creditoPGEntregaIDs = $data['credito_pg_entrega'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $creditoPGEntregaIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = CreditoOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaCreditoPagamentoNaRetirada(Request $request) {
        $data = $request->all();
        $valeRefeicaoAtivado = $data['pagamento_na_retirada_ativado'];
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $storeID = $buscaALoja->id;

        // Atualiza o campo 'retirada' para todas as opções relevantes
        CreditoOpcao::where('tipo', 'pagamento_na_retirada')->where('store_id', $storeID)
        ->update(['pagamento_na_retirada_ativado' => $valeRefeicaoAtivado]);

        $opcoes = CreditoOpcao::where('tipo', 'pagamento_na_retirada')
            ->where('store_id', $storeID)
            ->get();

        if (!empty($data['credito_pg_retirada'])) {
            $creditoPGEntregaIDs = $data['credito_pg_retirada'];
            foreach ($opcoes as $opcao) {
                $selecionada = in_array($opcao->id, $creditoPGEntregaIDs);
                $opcao->update([
                    'selecionada' => $selecionada,
                ]);
            }
        } else {
            //Desmarca todo mundo
            foreach ($opcoes as $opcao) {
                $find = CreditoOpcao::find($opcao->id);
                $find->update(['selecionada' => 0]);

            }
        }
    }

    public function salvaMercadoPagoConfigLojista(Request $request) {
        // 1- Ativado 0 - Desativado
        $request->pagamento_digital_no_app_ativado == "1" ? $request->validate([
            'access_token' => 'required',
            'public_key' => 'required',
        ]) : [];

        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $verificaSeExiste = MercadoPagoConfigLojista::where('store_id', $buscaALoja->id)->first();
        $dados = [
            'cartao_ativado' => $request->cartao_ativado,
            'pix_ativado' => $request->pix_ativado,
            'access_token' =>$request->access_token,
            'public_key' =>$request->public_key,
            'store_id' => $buscaALoja->id,
            'pagamento_digital_no_app_ativado' => $request->pagamento_digital_no_app_ativado,
        ];

        if(!empty($verificaSeExiste)) {
            $verificaStore = MercadoPagoConfigLojista::where('store_id', $buscaALoja->id)->first();
            $verifica = MercadoPagoConfigLojista::find($verificaStore->id);
            $verifica->update($dados);
            Toastr::success('Dados atualizados com sucesso.');
        } else {
            MercadoPagoConfigLojista::create($dados);
            Toastr::success('Dados criados com sucesso!');
        }
    }

    public function tratamentoPgRetiradaDebitoOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $refeicaoPagamentoNaEntrega = [];
        $opcoesStore = DebitoOpcoes::where('tipo', 'pagamento_na_retirada')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = DebitoOpcoes::where('tipo', 'pagamento_na_retirada')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $refeicaoPagamentoNaEntrega;
    }

    public function tratamentoPgEntregaDebitoOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $refeicaoPagamentoNaEntrega = [];
        $opcoesStore = DebitoOpcoes::where('tipo', 'pagamento_na_entrega')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = DebitoOpcoes::where('tipo', 'pagamento_na_entrega')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $refeicaoPagamentoNaEntrega;
    }

    public function tratamentoPgRetiradaCreditoOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $creditoOPs = [];
        $opcoesStore = CreditoOpcao::where('tipo', 'pagamento_na_retirada')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = CreditoOpcao::where('tipo', 'pagamento_na_retirada')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $creditoOPs[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $creditoOPs[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $creditoOPs;
    }

    public function tratamentoPgEntregaCreditoOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $creditoOPs = [];
        $opcoesStore = CreditoOpcao::where('tipo', 'pagamento_na_entrega')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = CreditoOpcao::where('tipo', 'pagamento_na_entrega')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $creditoOPs[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $creditoOPs[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $creditoOPs;
    }

    public function tratamentoPgEntregaOutrosOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $creditoOPs = [];
        $opcoesStore = OutrosOpcao::where('tipo', 'pagamento_na_entrega')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = OutrosOpcao::where('tipo', 'pagamento_na_entrega')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $creditoOPs[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $creditoOPs[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $creditoOPs;
    }

    public function tratamentoPgRetiradaOutrosOpcoeos() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();
        $creditoOPs = [];
        $opcoesStore = OutrosOpcao::where('tipo', 'pagamento_na_retirada')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = OutrosOpcao::where('tipo', 'pagamento_na_retirada')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $creditoOPs[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $creditoOPs[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $creditoOPs;
    }

    public function tratamentoPgEntregaValeRefeicao() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $refeicaoPagamentoNaEntrega = [];
        $opcoesStore = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_entrega')->whereNull('store_id')->get();
            foreach ($opcoesPadrao as $opcaoPadrao) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $refeicaoPagamentoNaEntrega;
    }

    public function tratamentoPgRetiradaValeRefeicao() {
        $idVendedor = \App\CentralLogics\Helpers::get_loggedin_user()->id;
        $buscaALoja = Store::where('vendor_id', $idVendedor)->first();

        $refeicaoPagamentoNaEntrega = [];
        $opcoesStore = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')
        ->where('store_id', $buscaALoja->id)
        ->get();

        if ($opcoesStore->isEmpty()) {
            $opcoesPadrao = ValeRefeicaoOpcao::where('tipo', 'pagamento_na_retirada')->whereNull('store_id')->get();

            foreach ($opcoesPadrao as $opcaoPadrao) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoPadrao->id,
                    'selecionada' => $opcaoPadrao->selecionada,
                    'img' => $opcaoPadrao->img,
                    'titulo' => $opcaoPadrao->titulo,
                ];
            }
        } else {
            foreach ($opcoesStore as $opcaoStore) {
                $refeicaoPagamentoNaEntrega[] = [
                    'id' => $opcaoStore->id,
                    'selecionada' => $opcaoStore->selecionada,
                    'img' => $opcaoStore->img,
                    'titulo' => $opcaoStore->titulo,
                ];
            }
        }

        return $refeicaoPagamentoNaEntrega;
    }

    public function buscaMetodosDePagamentoECredenciaisMercadoPagoAPI($store_id) {
        try {
            $buscaALoja = Store::where('vendor_id', $store_id)->first();
            $findDadosConfigMP = MercadoPagoConfigLojista::where('store_id', $buscaALoja->id)->first();

            //Apenas com ValeRefeicaoOpcao eu ja consigo saber se estao desativados para todos pq muda status de todo mundo
            $pagamentoNaEntregaAtivado = ValeRefeicaoOpcao::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_entrega')->first();
            $pagamentoNaRetirada = ValeRefeicaoOpcao::where('store_id', $buscaALoja->id)->where('tipo', 'pagamento_na_retirada')->first();
            $dados = [
                'mercado_pago_config_lojistas' => $findDadosConfigMP,
                'pagamento_na_entrega_ativado' => $pagamentoNaEntregaAtivado->pagamento_na_entrega_ativado == 0 ? false : true,
                'pagamento_na_retirada_ativado' => $pagamentoNaRetirada->pagamento_na_retirada_ativado == 0 ? false : true,
            ];

            return response()->json([
                $dados
            ], 200);
            

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function verificaSeLojistaTemPixECartaoAtivados($store_id) {
        try {
            $buscaALoja = Store::where('vendor_id', $store_id)->first();
            $findDadosConfigMP = MercadoPagoConfigLojista::where('store_id', $buscaALoja->id)->first();
            if ($findDadosConfigMP == null) {
                return response()->json([
                    'status'=> 'metodo_de_pagamento_nao_configurado'
                ], 200);
            } else {
            

                return response()->json([
                     'status'=> 'metodo_de_pagamento_configurado',
                       'pagamento_digital_no_app_ativado' => $findDadosConfigMP->pagamento_digital_no_app_ativado == 0 ? false : true,
                    'pix_ativado' => $findDadosConfigMP->pix_ativado== 0 ? false : true,
                    'cartao_ativado' => $findDadosConfigMP->cartao_ativado== 0 ? false : true,
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
