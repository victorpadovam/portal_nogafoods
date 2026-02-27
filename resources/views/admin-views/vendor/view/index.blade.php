@extends('layouts.admin.app')

@section('title', $store->name)

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/admin/css/croppie.css') }}" rel="stylesheet">
@endpush

<style>
    /* Estilos personalizados para o Dropzone */
    .dropzone-custom {
        border: 2px dashed #3699FF !important;
        border-radius: 10px !important;
        background: #F3F6F9 !important;
        min-height: 150px !important;
        padding: 20px !important;
    }

    .dropzone-custom .dz-message {
        margin: 3em 0 !important;
        color: #7E8299 !important;
        font-size: 1.1rem !important;
    }

    .dropzone-custom .dz-preview {
        margin: 10px !important;
    }

    .dropzone-custom .dz-preview .dz-image {
        border-radius: 10px !important;
        width: 120px !important;
        height: 120px !important;
    }

    .dropzone-custom .dz-preview .dz-details {
        padding: 10px !important;
    }

    .dropzone-custom .dz-preview .dz-success-mark,
    .dropzone-custom .dz-preview .dz-error-mark {
        margin-top: 40px !important;
    }

    .logo-preview-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .edit-logo-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 10;
        padding: 4px 6px;
    }

    .logo-preview {
        display: block;
        max-width: 100%;
        border-radius: 8px;
    }
</style>
<style>
    /* Estilos personalizados para a área de upload */
    .upload-area {
        border: 2px dashed #3699FF;
        border-radius: 10px;
        background: #F3F6F9;
        min-height: 150px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .upload-area:hover {
        background: #E1F0FF;
        border-color: #0D6EFD;
    }

    .upload-area.dragover {
        background: #D1E9FF;
        border-color: #0D6EFD;
        transform: scale(1.02);
    }

    .upload-area .upload-icon {
        font-size: 48px;
        color: #3699FF;
        margin-bottom: 15px;
    }

    .upload-area .upload-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2D3748;
        margin-bottom: 8px;
    }

    .upload-area .upload-subtitle {
        font-size: 1rem;
        color: #718096;
        margin-bottom: 4px;
    }

    .upload-area .upload-note {
        font-size: 0.875rem;
        color: #A0AEC0;
    }

    .logo-preview-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #3699FF;
        margin: 0 auto;
    }

    /* Estilo para quando há um arquivo selecionado */
    .file-selected {
        background: #E8F5E9;
        border-color: #28A745;
    }

    .file-selected .upload-icon {
        color: #28A745;
    }

    .file-info {
        margin-top: 15px;
        padding: 10px;
        background: white;
        border-radius: 5px;
        border: 1px solid #E2E8F0;
    }

    .file-name {
        font-weight: 600;
        color: #2D3748;
    }

    .file-size {
        font-size: 0.875rem;
        color: #718096;
    }

    .remove-file-btn {
        margin-top: 10px;
    }

    /* Ocultar input de arquivo */
    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
</style>
<style>
    .logo-preview-container {
        text-align: left;
        position: relative;
        margin-bottom: 20px;
    }

    .logo-preview-wrapper {
        position: relative !important;
        display: inline-block;
        overflow: visible !important;
    }


    .logo-preview {
        width: 100px;
        /* Tamanho da logo, ajuste conforme necessário */
        height: 100px;
        /* Tamanho da logo, ajuste conforme necessário */
        border-radius: 8px;
        /* Borda arredondada para a imagem */
    }

    #edit-logo-btn {
        position: absolute;
        /* Posiciona o botão de editar em cima da imagem */
        top: 5px;
        /* Ajuste da posição vertical do botão */
        right: 5px;
        /* Ajuste da posição horizontal do botão */
        background-color: #007bff;
        /* Cor do botão (azul, pode alterar) */
        color: white;
        /* Cor do ícone */
        border-radius: 50%;
        /* Faz o botão circular */
        width: 30px;
        /* Tamanho do botão */
        height: 30px;
        /* Tamanho do botão */
        display: flex;
        /* Flexbox para centralizar o ícone */
        justify-content: center;
        /* Alinha o conteúdo horizontalmente */
        align-items: center;
        /* Alinha o conteúdo verticalmente */
        border: none;
        /* Remove borda padrão */
        cursor: pointer;
        /* Aponta o cursor para indicar que é clicável */
    }

    #edit-logo-btn:hover {
        background-color: #0056b3;
        /* Cor do botão ao passar o mouse (pode alterar) */
    }

    .text-muted {
        font-size: 14px;
    }
</style>
<style>
    .logo-preview-container {
        text-align: left;
        position: relative;
        margin-bottom: 20px;
    }

    .logo-preview-wrapper {
        position: relative;
        display: inline-block;
        width: 100px;
        /* Mesmo tamanho da imagem */
        height: 100px;
        /* Mesmo tamanho da imagem */
        /* border-radius: 50%; Faz o wrapper circular */
        overflow: hidden;
        /* Esconde qualquer conteúdo que ultrapasse */
    }

    .logo-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        /* Faz o círculo azul */
        object-fit: cover;
        border: 3px solid #3699FF;
        /* Borda azul */
        display: block;
        /* Remove espaço extra abaixo da imagem */
    }

    #edit-logo-btn {
        position: absolute !important;
        top: 8px;
        right: 8px;
        z-index: 9999 !important;
    }


    #edit-logo-btn .bi-pencil {
        font-size: 14px;
        /* Tamanho do ícone */
        display: block;
        /* Garante que o ícone ocupe espaço */
        line-height: 1;
        /* Remove espaçamento extra */
        margin: 0;
        /* Remove margens */
        padding: 0;
        /* Remove padding */
    }

    #edit-logo-btn:hover {
        background-color: #0056b3;
        /* Cor do botão ao passar o mouse */
        transform: scale(1.1);
        /* Efeito de zoom ao passar o mouse */
        transition: transform 0.2s ease;
    }

    /* Opcional: Para visualização de exemplo */

    .logo-preview-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
    }

    #logo-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;

        display: block;
    }

    #edit-photo-btn {
        position: absolute;
        top: 6px;
        right: 6px;

        width: 28px;
        height: 28px;

        background: #fff;
        border: none;
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        cursor: pointer;
        z-index: 10;

        box-shadow: 0 2px 6px rgba(0, 0, 0, .25);
    }

    #edit-photo-btn i {
        font-size: 12px;
        color: #333;
    }

    .image-edit-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
    }

    .image-edit-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .edit-image-btn {
        position: absolute;
        top: 8px;
        right: 8px;

        width: 32px;
        height: 32px;

        background: #ffffff !important;
        border: none;
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        cursor: pointer;
        z-index: 999;

        box-shadow: 0 3px 8px rgba(0, 0, 0, .35);
    }

    .edit-image-btn i {
        font-size: 13px;
        color: #333;
    }

    /* LOGO - mantém quadrado */
    .image-edit-wrapper {
        width: 140px;
        height: 140px;
    }

    /* CAPA - maior (2:1) */
    .__custom-upload-img .image-edit-wrapper {
        width: 300px !important;
        /* height: 160px; */
    }

    /* imagem da capa ocupa tudo */
    .__custom-upload-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .page-header {
        width: 100%;
        /* ou a largura do elemento base */
        max-width: 1200px;
        /* se houver um limite */
        margin: 0 auto;
        /* se for centralizado */
        padding: 20px;
        /* ajuste conforme o elemento base */
    }


    .elemento-base,
    .page-header {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        box-sizing: border-box;
    }

    .d-flex.justify-content-between.align-items-center.flex-wrap.gap-2 {
        align-items: stretch;
        /* para que os filhos tenham a mesma altura */
    }


    .store-header-sticky {
        position: sticky;
        top: 70px;
        /* ajuste conforme a altura do header do admin */
        z-index: 999;
        background: #fff;
        /* mesma cor do fundo */
    }

    /* evita que o conteúdo "pule" */
    .store-header-sticky .page-header {
        margin-bottom: 16px;
    }

    /* sombra leve quando está grudado */
    .store-header-sticky.is-sticky {
        box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
    }

    /* Corrige z-index do header sticky vs modal */
    .store-header-sticky {
        z-index: 100 !important;
        /* era 999, abaixo do modal que é 1050 */
    }

    /* Garante que o modal e backdrop fiquem acima de tudo */
    .modal {
        z-index: 1055 !important;
    }

    .modal-backdrop {
        z-index: 1050 !important;
    }
</style>

@section('content')

    @if (!empty($store->contratoPdf))
        @php
            $contratoPdf = $store->contratoPdf;
            $contratoPdf = str_replace('https://portal.nogafoods.com.br/', '', $contratoPdf);
            $contratoUrl = 'https://portal.nogafoods.com.br/storage/app/public/store/contracts/' . $contratoPdf;
        @endphp

        <div class="modal fade" id="contratoModal" tabindex="-1" role="dialog" aria-labelledby="contratoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="max-width: 90vw;">
                <div class="modal-content" style="height: 90vh;">

                    <!-- HEADER -->
                    <div class="modal-header" style="background:#fff; border-bottom:1px solid #eee; padding:12px 20px;">
                        <div class="d-flex align-items-center">
                            <i class="tio-document-text text-primary mr-2" style="font-size:1.4rem;"></i>
                            <div>
                                <h5 class="modal-title mb-0 font-weight-bold" id="contratoModalLabel">
                                    CONTRATO DE INTERMEDIAÇÃO
                                </h5>
                                <small class="text-muted text-uppercase" style="font-size:10px; letter-spacing:1px;">
                                    Documento Oficial Noga Foods Marketplace
                                </small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <!-- Botão Baixar -->
                            <a href="{{ $contratoUrl }}" download class="btn btn-sm btn--primary mr-3" title="Baixar PDF">
                                <i class="tio-download mr-1"></i> Baixar PDF
                            </a>
                            <!-- Fechar -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"
                                style="font-size:1.5rem;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <!-- BODY: visualizador PDF -->
                    <div class="modal-body p-0" style="flex:1; overflow:hidden; height: calc(90vh - 65px);">
                        <iframe src="{{ $contratoUrl }}" style="width:100%; height:100%; border:none;"></iframe>
                        {{-- Fallback caso o navegador não suporte iframe PDF --}}
                        <div id="contratoFallback" style="display:none; text-align:center; padding:40px;">
                            <i class="tio-document-text" style="font-size:4rem; color:#ccc;"></i>
                            <p class="mt-3 text-muted">Seu navegador não suporta a visualização inline de PDF.</p>
                            <a href="{{ $contratoUrl }}" download class="btn btn--primary mt-2">
                                <i class="tio-download mr-1"></i> Baixar PDF para visualizar
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            // Carrega o src do iframe apenas quando o modal abre (evita request desnecessário)
            $('#contratoModal').on('show.bs.modal', function() {
                var iframe = document.getElementById('contratoIframe');
                if (!iframe.src || iframe.src === window.location.href) {
                    iframe.src = iframe.getAttribute('data-src');
                }
            });

            // Limpa o iframe ao fechar para liberar memória
            $('#contratoModal').on('hidden.bs.modal', function() {
                document.getElementById('contratoIframe').src = '';
            });

            // Fallback: se o iframe não carregar o PDF, mostra o botão de download
            document.getElementById('contratoIframe').addEventListener('error', function() {
                this.style.display = 'none';
                document.getElementById('contratoFallback').style.display = 'block';
            });
        </script>
    @endif

    <div class="content container-fluid">



        <form action="{{ route('updateViewStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $store->id }}">

            <div class="store-header-sticky">
                @include('admin-views.vendor.view.partials._header', ['store' => $store])
            </div>






            <!-- Page Heading -->
            @if ($store->vendor->status)
                <div class="row g-3 text-capitalize">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-md-4">
                        <div class="card h-100 card--bg-1">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <h5 class="cash--subtitle text-white">
                                    {{ translate('messages.collected_cash_by_store') }}
                                </h5>
                                <div class="d-flex align-items-center justify-content-center mt-3">
                                    <div class="cash-icon mr-3">
                                        <img src="{{ asset('public/assets/admin/img/cash.png') }}" alt="img">
                                    </div>
                                    <h2 class="cash--title text-white">
                                        {{ \App\CentralLogics\Helpers::format_currency($wallet->collected_cash) }}</h2>
                                </div>
                            </div>
                            <div class="card-footer pt-0 bg-transparent border-0">
                                <button class="btn text-white text-capitalize bg--title h--45px w-100" id="collect_cash"
                                    type="button" data-toggle="modal" data-target="#collect-cash"
                                    title="Collect Cash">{{ translate('messages.collect_cash_from_store') }}
                                </button>
                                {{-- <a class="btn text-white text-capitalize bg--title h--45px w-100" href="{{$store->vendor->status ? route('admin.transactions.account-transaction.index') : '#'}}" title="{{translate('messages.goto_account_transaction')}}">{{translate('messages.collect_cash_from_store')}}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-3">
                            <!-- Panding Withdraw Card Example -->
                            <div class="col-sm-6">
                                <div class="resturant-card card--bg-2">
                                    <h4 class="title">
                                        {{ \App\CentralLogics\Helpers::format_currency($wallet->pending_withdraw) }}</h4>
                                    <div class="subtitle">{{ translate('messages.pending_withdraw') }}</div>
                                    <img class="resturant-icon w--30"
                                        src="{{ asset('public/assets/admin/img/transactions/pending.png') }}"
                                        alt="transaction">
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-sm-6">
                                <div class="resturant-card card--bg-3">
                                    <h4 class="title">
                                        {{ \App\CentralLogics\Helpers::format_currency($wallet->total_withdrawn) }}</h4>
                                    <div class="subtitle">{{ translate('messages.total_withdrawal_amount') }}</div>
                                    <img class="resturant-icon w--30"
                                        src="{{ asset('public/assets/admin/img/transactions/withdraw-amount.png') }}"
                                        alt="transaction">
                                </div>
                            </div>

                            <!-- Collected Cash Card Example -->
                            <div class="col-sm-6">
                                <div class="resturant-card card--bg-4">
                                    <h4 class="title">
                                        {{ \App\CentralLogics\Helpers::format_currency($wallet->balance > 0 ? $wallet->balance : 0) }}
                                    </h4>
                                    <div class="subtitle">{{ translate('messages.withdraw_able_balance') }}</div>
                                    <img class="resturant-icon w--30"
                                        src="{{ asset('public/assets/admin/img/transactions/withdraw-balance.png') }}"
                                        alt="transaction">
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-sm-6">
                                <div class="resturant-card card--bg-1">
                                    <h4 class="title">
                                        {{ \App\CentralLogics\Helpers::format_currency($wallet->total_earning) }}</h4>
                                    <div class="subtitle">{{ translate('messages.total_earning') }}</div>
                                    <img class="resturant-icon w--30"
                                        src="{{ asset('public/assets/admin/img/transactions/earning.png') }}"
                                        alt="transaction">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif




            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2">
                            <i class="tio-shop-outlined"></i>
                        </span>
                        <span class="ml-1">DADOS DO ESTABELECIMENTO</span>
                    </h5>
                </div>
                <div class="card-body">

                    {{-- IMAGEM NO TOPO --}}
                    <div class="resturant--info-address mb-4 d-flex gap-3">

                        <!-- LOGO -->
                        <div class="d-flex flex-column">
                            <span class="image-label">Logo (1:1)</span>

                            <div class="logo position-relative image-edit-wrapper ">
                                <img class="editable-image onerror-image" src="{{ asset($store->logo) }}"
                                    alt="{{ $store->name }} Logo">

                                <button type="button" class="edit-image-btn" title="Alterar logo">
                                    <i class="fa fa-pen"></i>
                                </button>

                                <input type="file" name="logo" class="image-file-input" accept=".png,.jpg,.jpeg"
                                    hidden>
                            </div>
                        </div>

                        <!-- CAPA -->
                        <div class="d-flex flex-column __custom-upload-img">
                            <span class="image-label">Capa Loja (2:1)</span>

                            <div class="logo position-relative image-edit-wrapper">
                                <img class="cover-img editable-image onerror-image"
                                    src="{{ asset('storage/store/' . $store->destaque) }}"
                                    alt="{{ $store->name }} Capa">


                                <button type="button" class="edit-image-btn" title="Alterar capa">
                                    <i class="fa fa-pen"></i>
                                </button>

                                <input type="file" name="destaque" class="image-file-input" accept=".png,.jpg,.jpeg"
                                    hidden>
                            </div>
                        </div>

                    </div>

                    {{-- IMAGEM NO TOPO --}}



                    {{-- FORMULÁRIO --}}
                    <div class="row g-3">

                        {{-- Nome --}}
                        <div class="col-md-6">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ $store->name }}">
                        </div>

                        {{-- CNPJ --}}
                        <div class="col-md-6">
                            <label class="form-label">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control" value="{{ $store->cnpj }}">
                        </div>

                        {{-- Razão Social --}}
                        <div class="col-md-6">
                            <label class="form-label">Razão Social</label>
                            <input type="text" name="social_reason" class="form-control"
                                value="{{ $store->social_reason }}">
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $store->email }}">
                        </div>

                        {{-- Telefone --}}
                        <div class="col-md-6">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $store->phone }}">
                        </div>

                        {{-- Zona --}}
                        <div class="col-md-6">
                            <label class="form-label">Zona</label>
                            <select name="zone_id" class="form-control">
                                <option value="">
                                    {{ $store?->zone?->name ?? translate('zone_deleted') }}
                                </option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="card-header-icon mr-2">
                                <i class="tio-map-outlined"></i>
                            </span>
                            <span class="ml-1">LOCALIZAÇÃO: MAPA LOCAL</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Dados de localização --}}
                            <div class="col-lg-6">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Cidade</label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ $store->city }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Estado</label>
                                        <input type="text" name="state" class="form-control"
                                            value="{{ $store->state }}">
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label">Endereço</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $store->address }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Número</label>
                                        <input type="text" name="number" class="form-control"
                                            value="{{ $store->number }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" name="neighborhood" class="form-control"
                                            value="{{ $store->neighborhood }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">CEP</label>
                                        <input type="text" name="cep" class="form-control"
                                            value="{{ $store->cep }}">
                                    </div>

                                </div>
                            </div>

                            {{-- Mapa --}}
                            <div class="col-lg-6">
                                <div id="map" class="single-page-map border rounded" style="min-height: 300px;">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="card-header-icon me-2">
                                <i class="tio-call-talking"></i>
                            </span>
                            <span>CONTATOS E REDES SOCIAIS</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Rede social</label>
                                <input type="text" class="form-control" name="socialNetwork"
                                    value="{{ $store->socialNetwork }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefone 1</label>
                                <input type="text" name="firstPhone" class="form-control"
                                    value="{{ $store->firstPhone }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefone 2</label>
                                <input type="text" class="form-control" name="secondPhone"
                                    value="{{ $store->secondPhone }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ $store->whatsapp }}">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="card-header-icon me-2">
                                {{-- <i class="tio-call-talking"></i> --}}
                            </span>
                            <span>FUNCIONAMENTO DA LOJA</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Categoria / Módulo
                                </label>

                                <select name="module_id" class="form-control">
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}" @selected($module->id == $store->module_id)>
                                            {{ $module->module_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-md-6">
                                <label class="form-label">Tipo de negócio</label>
                                <input type="text" class="form-control" name="businessType"
                                    value="{{ $store->businessType }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Serviço do Estabelecimento</label>
                                <input type="text" class="form-control" name="serviceType"
                                    value="{{ $store->serviceType }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Possui serviço de entrega?</label>
                                <input type="text" class="form-control" name="hasDeliveryService"
                                    value="{{ $store->hasDeliveryService ? 'Sim' : 'Não' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Taxa média de entrega</label>
                                <input type="text" class="form-control" name="deliveryFee"
                                    value="{{ $store->deliveryFee }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Possui conta no Mercado Pago?</label>
                                <input type="text" class="form-control" name="hasMercadoPago"
                                    value="{{ $store->hasMercadoPago ? 'Sim' : 'Não' }}">
                            </div>

                            @php
                                $horarios = $store->listaHorarioDeFuncionamentoDaLoja;

                                if (is_string($horarios)) {
                                    $horarios = json_decode($horarios, true);
                                }

                                $horarios = $horarios ?? [];
                            @endphp


                            @php
                                $pagamentos = $pagamentos ?? [];
                            @endphp

                            <div class="col-md-6">
                                <label class="form-label">Métodos de pagamento</label>

                                @if (count($pagamentos))
                                    <ul class="ps-3 mb-0">
                                        @foreach ($pagamentos as $pagamento)
                                            <li>{{ $pagamento }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <input type="text" class="form-control" value="Não informado">
                                @endif
                            </div>




                            <div class="col-md-6">
                                <label class="form-label">Pagamento padrão</label>
                                <input type="text" class="form-control" name="pagamento_padrao"
                                    value="{{ $store->pagamento_padrao ? 'Sim' : 'Não' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Valor do pedido mínimo</label>
                                <input type="text" class="form-control" name="minimumOrder"
                                    value="{{ $store->minimumOrder }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempo aproximado para delivery</label>
                                <input type="text" class="form-control" name="tempo_aproximada_para_delivery"
                                    value="{{ $store->tempo_aproximada_para_delivery }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempo aproximado para retirada</label>
                                <input type="text" class="form-control" name="tempo_aproximada_para_retirada"
                                    value="{{ $store->tempo_aproximada_para_retirada }}">
                            </div>

                        </div>
                    </div>
                </div>



                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0">HORÁRIOS DE FUNCIONAMENTO</h5>
                    </div>

                    <div class="card-body">
                        @foreach ($horarios as $dia => $dados)
                            <div class="border rounded mb-3">

                                {{-- HEADER DO DIA --}}
                                <div
                                    class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
                                    <strong class="text-uppercase">{{ $dia }}</strong>

                                    <div class="d-flex gap-3">
                                        <label class="d-flex align-items-center gap-1 m-0">
                                            <input type="radio" name="horarios[{{ $dia }}][enabled]"
                                                value="1" {{ $dados['enabled'] ? 'checked' : '' }}>
                                            Aberto
                                        </label>

                                        <label class="d-flex align-items-center gap-1 m-0">
                                            <input type="radio" name="horarios[{{ $dia }}][enabled]"
                                                value="0" {{ !$dados['enabled'] ? 'checked' : '' }}>
                                            Fechado
                                        </label>
                                    </div>
                                </div>

                                {{-- INTERVALOS --}}
                                <div class="p-3">
                                    @foreach ($dados['intervals'] as $i => $intervalo)
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">De</span>
                                                    <input type="time" class="form-control"
                                                        name="horarios[{{ $dia }}][intervals][{{ $i }}][start]"
                                                        value="{{ $intervalo['start'] }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">Até</span>
                                                    <input type="time" class="form-control"
                                                        name="horarios[{{ $dia }}][intervals][{{ $i }}][end]"
                                                        value="{{ $intervalo['end'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>




                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="card-header-icon me-2">
                                {{-- <i class="tio-call-talking"></i> --}}
                            </span>
                            <span>CONTRATO E CONTATO</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Como você quer receber seu contrato?</label>
                                <input type="text" class="form-control" name="contractReceiveOption"
                                    value="{{ $store->contractReceiveOption }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Como você conheceu a Noga Foods?</label>
                                <input type="text" class="form-control" name="howYouMeetNogaFoods"
                                    value="{{ $store->howYouMeetNogaFoods }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Você recebeu a visita do nosso representante?</label>
                                <input type="text" class="form-control" name="receivedOurRepresentative"
                                    value="{{ $store->receivedOurRepresentative }}">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="card-header-icon me-2">
                                {{-- <i class="tio-call-talking"></i> --}}
                            </span>
                            <span>IDENTIFICAÇÃO DO RESPONSÁVEL</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nome do proprietário ou responsável</label>
                                <input type="text" class="form-control" name="ownerName"
                                    value="{{ $store->ownerName }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cargo na empresa</label>
                                <input type="text" class="form-control" name="ownerCargo"
                                    value="{{ $store->ownerCargo }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="ownerEmail"
                                    value="{{ $store->ownerEmail }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" name="ownerPhone"
                                    value="{{ $store->ownerPhone }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Observações</label>
                                <textarea class="form-control" name="observation" rows="3">{{ $store->observation }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title m-0 d-flex align-items-center">
                            <span class="ml-1">DOCUMENTOS DO RESPONSÁVEL</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-6">
                                <div class="resturant--info-address">
                                    <ul class="address-info list-unstyled text-dark">

                                        <!-- DOCUMENTO FRENTE -->
                                        <li class="d-flex align-items-center gap-3 mb-3">
                                            <span><strong>Foto (frente)</strong></span>

                                            <div class="image-edit-wrapper">

                                                <img class="editable-image onerror-image"
                                                    src="{{ asset('storage/store/documents/' . $store->owenerDocumentoComFotoFrente) }}"
                                                    alt="{{ $store->name }} frente">

                                                <button type="button" class="edit-image-btn"
                                                    title="Alterar documento (frente)">
                                                    <i class="fa fa-pen"></i>
                                                </button>

                                                <input type="file" name="owenerDocumentoComFotoFrente"
                                                    class="image-file-input" accept=".png,.jpg,.jpeg" hidden>
                                            </div>
                                        </li>

                                        <!-- DOCUMENTO VERSO -->
                                        <li class="d-flex align-items-center gap-3">
                                            <span><strong>Foto (verso)</strong></span>

                                            <div class="image-edit-wrapper">

                                                <img class="editable-image onerror-image"
                                                    src="{{ asset('storage/store/documents/' . $store->owenerDocumentoComFotoVerso) }}"
                                                    alt="{{ $store->name }} verso">

                                                <button type="button" class="edit-image-btn"
                                                    title="Alterar documento (verso)">
                                                    <i class="fa fa-pen"></i>
                                                </button>

                                                <input type="file" name="owenerDocumentoComFotoVerso"
                                                    class="image-file-input" accept=".png,.jpg,.jpeg" hidden>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pt-3 g-3">
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title m-0 d-flex align-items-center">
                                    <span class="card-header-icon mr-2">
                                        <i class="tio-user"></i>
                                    </span>
                                    <span class="ml-1">{{ translate('messages.owner_info') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="resturant--info-address">
                                    <div class="avatar avatar-xxl avatar-circle avatar-border-lg">
                                        <img class="avatar-img onerror-image"
                                            data-onerror-image="{{ asset('public/assets/admin/img/160x160/img1.jpg') }}"
                                            src="{{ \App\CentralLogics\Helpers::get_image_helper(
                                                $store->vendor,
                                                'image',
                                                asset('storage/app/public/vendor') . '/' . $store->vendor->image ?? '',
                                                asset('public/assets/admin/img/160x160/img1.jpg'),
                                                'vendor/',
                                            ) }}"
                                            alt="Image Description">
                                    </div>
                                    <ul class="address-info address-info-2 list-unstyled list-unstyled-py-3 text-dark">
                                        <li>
                                            <h5 class="name">{{ $store->vendor->f_name }} {{ $store->vendor->l_name }}
                                            </h5>
                                        </li>
                                        <li>
                                            <i class="tio-call-talking nav-icon"></i>
                                            <span class="pl-1"><a
                                                    href="mailto:{{ $store->vendor->email }}">{{ $store->vendor->email }}</a>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="tio-email nav-icon"></i>
                                            <span class="pl-1"> <a href="tel:{{ $store->vendor->phone }}">
                                                    {{ $store->vendor->phone }} </a></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title m-0 d-flex align-items-center">
                                    <span class="card-header-icon mr-2">
                                        <i class="tio-crown"></i>
                                    </span>
                                    <span class="ml-1">{{ translate('messages.Business_Plan') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="resturant--info-address">
                                    <ul class="address-info address-info-2 list-unstyled list-unstyled-py-3 text-dark">

                                        @if ($store->store_business_model == 'commission')
                                            <li>
                                                <span> <strong>{{ translate('messages.Business_Plan') }}</span></strong>
                                                <span>:</span> &nbsp; {{ translate($store->store_business_model) }}
                                            </li>
                                            @php($admin_commission = \App\Models\BusinessSetting::where(['key' => 'admin_commission'])->first()?->value)
                                            <li>
                                                <span><strong>{{ translate('messages.Commission_percentage') }}</strong></span>
                                                <span>:</span> &nbsp;
                                                {{ $store->comission > 0 ? $store->comission : $admin_commission }} %
                                            </li>
                                        @elseif ($store->store_business_model == 'subscription')
                                            <li>
                                                <span> <strong>{{ translate('messages.Business_Plan') }}</span></strong>
                                                <span>:</span> &nbsp; {{ translate($store->store_business_model) }} &nbsp;
                                                @if ($store?->store_sub_update_application->is_trial == '1')
                                                    <small> <span
                                                            class="badge badge-info">{{ translate('messages.Free_trial') }}</span>
                                                    </small>
                                                @endif
                                            </li>
                                            <li>
                                                <span> <strong>{{ translate('messages.Package_name') }}</strong></span>
                                                <span>:</span> &nbsp;
                                                {{ $store?->store_sub_update_application?->package?->package_name ?? translate('Pacakge_not_found!!!') }}
                                            </li>
                                        @elseif ($store->store_business_model == 'unsubscribed')
                                            <li>
                                                <span> <strong>{{ translate('messages.Business_Plan') }}</span></strong>
                                                <span>:</span> &nbsp; {{ translate($store->store_business_model) }} &nbsp;

                                                <small> <span
                                                        class="badge badge-danger">{{ translate('messages.Expired') }}</span>
                                                </small>

                                            </li>
                                            <li>
                                                <span> <strong>{{ translate('messages.Package_name') }}</strong></span>
                                                <span>:</span> &nbsp;
                                                {{ $store?->store_sub_update_application?->package?->package_name ?? translate('Pacakge_not_found!!!') }}
                                            </li>
                                        @else
                                            <li>
                                                <span> <strong>{{ translate('messages.Business_Plan') }}</span></strong>
                                                <span>:</span> &nbsp; {{ translate('Have_n’t_Selected_Yet.') }}
                                            </li>
                                        @endif




                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- BOTÃO DE SALVAR
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn--primary text-capitalize font-weight-bold float-right mr-2">
                <i class="tio-save"></i> Salvar Alterações
            </button>
        </div> --}}
                </div>
        </form>

    </div>

    </div>

    <div class="modal fade" id="collect-cash" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ translate('messages.collect_cash_from_store') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.transactions.account-transaction.store') }}" method='post'
                        id="add_transaction">
                        @csrf
                        <input type="hidden" name="type" value="store">
                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <div class="form-group">
                            <label class="input-label">{{ translate('messages.payment_method') }} <span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input class="form-control" type="text" name="method" id="method" required
                                maxlength="191" placeholder="{{ translate('messages.Ex_:_Card') }}">
                        </div>
                        <div class="form-group">
                            <label class="input-label">{{ translate('messages.reference') }}</label>
                            <input class="form-control" type="text" name="ref" id="ref" maxlength="191">
                        </div>
                        <div class="form-group">
                            <label class="input-label">{{ translate('messages.amount') }} <span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input class="form-control" type="number" min=".01" step="0.01" name="amount"
                                id="amount" max="999999999999.99"
                                placeholder="{{ translate('messages.Ex_:_1000') }}">
                        </div>
                        <div class="btn--container justify-content-end">
                            <button type="submit" id="submit_new_customer"
                                class="btn btn--primary">{{ translate('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&callback=initMap&v=3.45.8">
    </script>
    <script>
        "use strict";
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        const myLatLng = {
            lat: {{ $store->latitude }},
            lng: {{ $store->longitude }}
        };
        let map;
        initMap();

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatLng,
            });
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "{{ $store->name }}",
            });
        }

        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function() {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function() {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        function request_alert(url, message) {
            Swal.fire({
                title: '{{ translate('messages.are_you_sure') }}',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{ translate('messages.no') }}',
                confirmButtonText: '{{ translate('messages.yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = url;
                }
            })
        }

        $('#add_transaction').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.transactions.account-transaction.store') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate('messages.transaction_saved') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href = '{{ route('admin.store.view', $store->id) }}';
                        }, 2000);
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.edit-image-btn').on('click', function() {
                const wrapper = $(this).closest('.image-edit-wrapper');
                wrapper.find('.image-file-input').click();
            });

            $('.image-file-input').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
                    alert('Formato inválido');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                const wrapper = $(this).closest('.image-edit-wrapper');
                const image = wrapper.find('.editable-image');

                reader.onload = function(e) {
                    image.attr('src', e.target.result);
                };

                reader.readAsDataURL(file);
            });

        });
    </script>
@endpush
