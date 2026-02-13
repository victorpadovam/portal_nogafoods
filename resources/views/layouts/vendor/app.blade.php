<!DOCTYPE html>
<?php
    if (env('APP_MODE') == 'demo') {
        $site_direction = session()->get('site_direction_vendor');
    }else{
        $site_direction = session()->has('vendor_site_direction')?session()->get('vendor_site_direction'):'ltr';
    }
    $country=\App\Models\BusinessSetting::where('key','country')->first();
$countryCode= strtolower($country?$country->value:'auto');
?>
{{-- {{ dd($countryCode) }} --}}
<html dir="{{ $site_direction }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="{{ $site_direction === 'rtl'?'active':'' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    @php($logo=\App\Models\BusinessSetting::where(['key'=>'icon'])->first())
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{\App\CentralLogics\Helpers::get_image_helper($logo,'value', asset('storage/app//business/').'/' . $logo?->value, asset('/assets/admin/img/160x160/img1.jpg') ,'business/' )}}">
    <!-- Font -->
    <link href="{{asset('/assets/admin/css/fonts.css')}}" rel="stylesheet">
    <!-- Estilos adicionais (CSS) -->
<style>

@font-face {
    font-family: 'Inter Bold';
    src: asset('fonts/Inter-Bold.otf') format('opentype');
    font-weight: bold;
    font-style: normal;
}

@font-face {
    font-family: 'Inter SemiBold';
    src: asset('fonts/Inter-SemiBold.otf') format('opentype');
    font-weight: bold;
    font-style: normal;
}

.titulosInterBoldColorBlack {
    font-family: 'Inter Bold', sans-serif;
    font-size: 25px;
    color: #000000;
    margin: 0;
}

.titulosInterMediumAviso {
    font-family: 'Inter SemiBold', sans-serif;
    font-size: 15px;
    color: #000000;
    margin: 0;
}

.text-alerta {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 25px;
}
.text-alertaSize15 {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 15px;
}
/* Modal Container */
#pagamento_pix .modal-dialog {
    position: absolute;
    width: 920px;
    /*height: 810.8px;*/
    max-width: 90vw;
    max-height: 90vh;
    margin: auto;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Modal Content */
#pagamento_pix .modal-content {
    width: 100%;
    height: 100%;
    padding: 20px;
    border-radius: 55px;
    background-color: #fff;
    border: none;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}

/* Header */
#pagamento_pix .modal-header {
    border-bottom: none;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    font-size: 24px;
    font-weight: bold;
}

/* QR Code Section */
#pagamento_pix .qr-code-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

/* Logo Pix */
#pagamento_pix .logo-pix {
    width: 120px; /* Ajuste de tamanho para melhor visualização */
    margin-bottom: 20px;
}

/* QR Code Imagem */
#pagamento_pix .qr-code-img {
    width: 200px;
    height: 200px;
    max-width: 300px;
    max-height: 300px;
    margin-bottom: 20px;
}

/* Texto e Input */
#pagamento_pix .qr-code-text {
    font-size: 18px;
    margin-bottom: 10px;
}

#pagamento_pix .input-group {
    display: flex;
    align-items: center;
    width: 50%;
    max-width: 1000px;
    border: 1px dashed #ccc;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}

#pagamento_pix .form-control {
    flex: 1;
    border: none;
    font-size: 16px;
    outline: none;
    padding-left: 10px;
}

/* Botão de Copiar */
#pagamento_pix .btn-copy {
    background-color: #FF3000;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    cursor: pointer;
}

/* Botões de Ação */
#pagamento_pix .modal-footer {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}


/* Modal Container */
#pagamento_pix-1 .modal-dialog {
    position: absolute;
    width: 920px;
    /*height: 810.8px;*/
    max-width: 90vw;
    max-height: 90vh;
    margin: auto;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}



@font-face {
font-family: 'Roboto-Medium';
src: asset('/assets/mercado_pogo/fonts/Roboto-Medium.ttf') format('truetype');
font-style: normal;
}
.text-roboto-medium {
font-family: 'Roboto-Medium', sans-serif;
 font-size: 15px;
 color: #6F6F6F;
}
@font-face {
    font-family: 'GoldPlay';
    src: asset('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff2') format('woff2'),
        asset('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff') format('woff');
    font-weight: bold;
    font-style: normal;
}
.text-alerta {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 25px;
}
.text-alertaSize15 {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 15px;
}

@font-face {
font-family: 'Roboto-Medium';
src: asset('/assets/mercado_pogo/fonts/Roboto-Medium.ttf') format('truetype');
font-style: normal;
}
.text-roboto-medium {
font-family: 'Roboto-Medium', sans-serif;
 font-size: 15px;
 color: #6F6F6F;
}
@font-face {
    font-family: 'GoldPlay';
    src: asset('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff2') format('woff2'),
        asset('/assets/mercado_pogo/fonts/GoldPlay-Bold.woff') format('woff');
    font-weight: bold;
    font-style: normal;
}
.text-alerta {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 25px;
}
.text-alertaSize15 {
    font-family: 'GoldPlay', sans-serif;
    font-weight: bold;
    color: black;
    font-size: 15px;
}
/* Modal Container */
#pagamento_pix-1 .modal-dialog {
    position: absolute;
    width: 920px;
    /*height: 810.8px;*/
    max-width: 90vw;
    max-height: 90vh;
    margin: auto;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Modal Content */
#pagamento_pix-1 .modal-content {
    width: 100%;
    height: 100%;
    padding: 20px;
    border-radius: 55px;
    background-color: #fff;
    border: none;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}

/* Header */
#pagamento_pix-1 .modal-header {
    border-bottom: none;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    font-size: 24px;
    font-weight: bold;
}

/* QR Code Section */
#pagamento_pix-1 .qr-code-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

/* Logo Pix */
#pagamento_pix-1 .logo-pix {
    width: 120px; /* Ajuste de tamanho para melhor visualização */
    margin-bottom: 20px;
}

/* QR Code Imagem */
#pagamento_pix-1 .qr-code-img {
    width: 200px;
    height: 200px;
    max-width: 300px;
    max-height: 300px;
    margin-bottom: 20px;
}

/* Texto e Input */
#pagamento_pix-1 .qr-code-text {
    font-size: 18px;
    margin-bottom: 10px;
}

#pagamento_pix-1 .input-group {
    display: flex;
    align-items: center;
    width: 50%;
    max-width: 1000px;
    border: 1px dashed #ccc;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}

#pagamento_pix-1 .form-control {
    flex: 1;
    border: none;
    font-size: 16px;
    outline: none;
    padding-left: 10px;
}

/* Botão de Copiar */
#pagamento_pix-1 .btn-copy {
    background-color: #FF5722;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    cursor: pointer;
}

/* Botões de Ação */
#pagamento_pix-1 .modal-footer {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}


/* Modal Container */
#modalsucesso .modal-dialog {
    position: absolute;
    width: 920px;
    /*height: 810.8px;*/
    max-width: 90vw;
    max-height: 90vh;
    margin: auto;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Modal Content */
#modalsucesso .modal-content {
    width: 100%;
    height: 100%;
    padding: 20px;
    border-radius: 55px;
    background-color: #fff;
    border: none;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}

/* Header */
#modalsucesso .modal-header {
    border-bottom: none;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    font-size: 24px;
    font-weight: bold;
}

/* QR Code Section */
#modalsucesso .qr-code-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
}

/* Logo Pix */
#modalsucesso .logo-pix {
    width: 120px; /* Ajuste de tamanho para melhor visualização */
    margin-bottom: 20px;
}

/* QR Code Imagem */
#modalsucesso .qr-code-img {
    width: 200px;
    height: 200px;
    max-width: 300px;
    max-height: 300px;
    margin-bottom: 20px;
}

/* Texto e Input */
#modalsucesso .qr-code-text {
    font-size: 18px;
    margin-bottom: 10px;
}

#modalsucesso .input-group {
    display: flex;
    align-items: center;
    width: 50%;
    max-width: 1000px;
    border: 1px dashed #ccc;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 20px;
}

#modalsucesso .form-control {
    flex: 1;
    border: none;
    font-size: 16px;
    outline: none;
    padding-left: 10px;
}

/* Botão de Copiar */
#modalsucesso .btn-copy {
    background-color: #FF5722;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    cursor: pointer;
}

/* Botões de Ação */
#modalsucesso .modal-footer {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}


</style>

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
        width: 100px; /* Tamanho da logo, ajuste conforme necessário */
        height: 100px; /* Tamanho da logo, ajuste conforme necessário */
        border-radius: 8px; /* Borda arredondada para a imagem */
    }

    #edit-logo-btn {
        position: absolute; /* Posiciona o botão de editar em cima da imagem */
        top: 5px; /* Ajuste da posição vertical do botão */
        right: 5px; /* Ajuste da posição horizontal do botão */
        background-color: #007bff; /* Cor do botão (azul, pode alterar) */
        color: white; /* Cor do ícone */
        border-radius: 50%; /* Faz o botão circular */
        width: 30px; /* Tamanho do botão */
        height: 30px; /* Tamanho do botão */
        display: flex; /* Flexbox para centralizar o ícone */
        justify-content: center; /* Alinha o conteúdo horizontalmente */
        align-items: center; /* Alinha o conteúdo verticalmente */
        border: none; /* Remove borda padrão */
        cursor: pointer; /* Aponta o cursor para indicar que é clicável */
    }

    #edit-logo-btn:hover {
        background-color: #0056b3; /* Cor do botão ao passar o mouse (pode alterar) */
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
        width: 100px; /* Mesmo tamanho da imagem */
        height: 100px; /* Mesmo tamanho da imagem */
        /* border-radius: 50%; Faz o wrapper circular */
        overflow: hidden; /* Esconde qualquer conteúdo que ultrapasse */
    }

    .logo-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%; /* Faz o círculo azul */
        object-fit: cover;
        border: 3px solid #3699FF; /* Borda azul */
        display: block; /* Remove espaço extra abaixo da imagem */
    }

#edit-logo-btn {
    position: absolute !important;
    top: 8px;
    right: 8px;
    z-index: 9999 !important;
}


    #edit-logo-btn .bi-pencil {
        font-size: 14px; /* Tamanho do ícone */
        display: block; /* Garante que o ícone ocupe espaço */
        line-height: 1; /* Remove espaçamento extra */
        margin: 0; /* Remove margens */
        padding: 0; /* Remove padding */
    }

    #edit-logo-btn:hover {
        background-color: #0056b3; /* Cor do botão ao passar o mouse */
        transform: scale(1.1); /* Efeito de zoom ao passar o mouse */
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

    box-shadow: 0 2px 6px rgba(0,0,0,.25);
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

    box-shadow: 0 3px 8px rgba(0,0,0,.35);
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
    width: 100%; /* ou a largura do elemento base */
    max-width: 1200px; /* se houver um limite */
    margin: 0 auto; /* se for centralizado */
    padding: 20px; /* ajuste conforme o elemento base */
}


.elemento-base, .page-header {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}
.d-flex.justify-content-between.align-items-center.flex-wrap.gap-2 {
    align-items: stretch; /* para que os filhos tenham a mesma altura */
}


.store-header-sticky {
    position: sticky;
    top: 70px; /* ajuste conforme a altura do header do admin */
    z-index: 999;
    background: #fff; /* mesma cor do fundo */
}

/* evita que o conteúdo "pule" */
.store-header-sticky .page-header {
    margin-bottom: 16px;
}

/* sombra leve quando está grudado */
.store-header-sticky.is-sticky {
    box-shadow: 0 4px 10px rgba(0,0,0,.08);
}



</style>
       <!-- Dropzone CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/basic.min.css" />

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin')}}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('/assets/admin')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/emogi-area.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/intltelinput/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/metodo-de-pagamento.css')}}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">



    @stack('css_or_js')

    <script src="{{asset('/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('/assets/admin')}}/css/toastr.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    

</head>


<body class="footer-offset">
        <?php
$wallet = \App\Models\StoreWallet::where('vendor_id', \App\CentralLogics\Helpers::get_vendor_id())->first();
$Payable_Balance = $wallet?->collected_cash  > 0 ? 1 : 0;

$cash_in_hand_overflow =  \App\Models\BusinessSetting::where('key', 'cash_in_hand_overflow_store')->first()?->value;
$cash_in_hand_overflow_store_amount =  \App\Models\BusinessSetting::where('key', 'cash_in_hand_overflow_store_amount')->first()?->value;
$val = (string) ($cash_in_hand_overflow_store_amount - (($cash_in_hand_overflow_store_amount * 10) / 100));
?>

@if ($Payable_Balance == 1 && $cash_in_hand_overflow && $wallet?->balance < 0 && $val <=abs($wallet?->collected_cash) )
        <script>
        // Abrir o modal automaticamente ao carregar a página
        document.addEventListener("DOMContentLoaded", function() {
            $('#pagamento_pix').modal('show');
        });
    </script>
<!-- Modal -->
<div class="modal fade" id="alerta_conta_suspensa" tabindex="-1" role="dialog" aria-labelledby="exceedLimitLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 p-4">
            <!-- Cabeçalho do Modal -->
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <div class="modal-body">
            <div class="qr-code-section">
            
                <!-- QR Code -->
                <img style="
    height: 180px;
" src="https://i.ibb.co/1dkTjzF/1200px-TAR-Exclamation-icon-svg-1.png" alt="QR Code" class="img-fluid rounded mb-3 qr-code-img">
            
                <!-- Texto adicional -->
                <p class=" titulosInterBoldColorBlack "> Sua conta está suspensa temporariamente!</p>

                   <!-- Texto adicional -->
                <p style=" padding-left: 150px; padding-right: 150px; " class=" titulosInterMediumAviso">O limite do valor de recebimentos das vendas do app no caixa da loja foi excedido Por favor realize o pagamento do valor devido, para continuar recebendo pedidos no aplicativo.</p>
                
                <div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;">
    <img src="https://media.tenor.com/2hNqKj3ArX8AAAAi/loading.gif" width="100" height="100">
    <p>Carregando QR Code...</p>
</div>


                
<a href="javascript:void(0);" onclick="carregarPagamento2('{{ $wallet->collected_cash }}', '{{ $wallet->vendor_id }}')">
    <button class="btn btn-copy mt-4" style="width: 400px;">Pagar Noga Foods</button>
</a>

                <br>
                <br>
            </div>
        </div>


            </div>

        </div>
    </div>
    
    
    <!-- Modal -->
<div class="modal fade" id="modalsucesso" tabindex="-1" role="dialog" aria-labelledby="exceedLimitLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 p-4">
            <!-- Cabeçalho do Modal -->
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <div class="modal-body">
            <div class="qr-code-section">
            
                <!-- QR Code -->
                <img style="
                    height: 180px;" src="https://i.ibb.co/Q3tzX9nV/checked-1.png" alt="QR Code" class="img-fluid rounded mb-3 qr-code-img">
            
                <!-- Texto adicional -->
                <p class=" titulosInterBoldColorBlack ">Pagamento realizado com sucesso!</p>

               <button class="btn btn-copy mt-4" style="width: 400px;" onclick="$('#modalsucesso').modal('hide');">Voltar</button>

                <br>
                <br>
            </div>
        </div>


            </div>

        </div>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="pagamento_pix-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 p-4">
            <!-- Cabeçalho do Modal -->
             <br>
            <div class="modal-header border-0">
                <h5 class="modal-title mx-auto text-alerta" style="padding-left: 200px;" id="exampleModalLabel">Aguardando Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <div class="modal-body">
            <div class="qr-code-section">
            
                 <img style="width: 90px;" src="https://i.ibb.co/s1QPZgh/Component-8.png" alt="Pix Icon" class="mb-3 logo-pix">


                <!-- QR Code -->
                <img  style="height: 150px;" alt="QR Code" class="img-fluid rounded mb-3 qrcode-pix">
                
                <!-- Texto e Input -->
               <div class="text-alertaSize15">Copie ou escaneie o QR CODE</div>
                <div class="input-group mt-2">
                    <input type="text" class="form-control copyPaste" id="pixCode" value='1122'  readonly>
                    
                    <!-- SVG Copiar Código -->
                    <svg onclick="copyPixCode()" 
                         xmlns="http://www.w3.org/2000/svg" 
                         xmlns:xlink="http://www.w3.org/1999/xlink" 
                         version="1.1" 
                         x="0px" 
                         y="0px" 
                         viewBox="0 0 100 125" 
                         style="width: 32px; height: 32px; cursor: pointer; fill: red;" 
                         xml:space="preserve">
                        <title>Copiar Código Pix</title>
                        <path d="M60.8,35H15.2c-4,0-7.2,3.2-7.2,7.2v45.7c0,3.9,3.2,7.2,7.2,7.2h45.7c3.9,0,7.2-3.2,7.2-7.2V42.2C68,38.2,64.8,35,60.8,35z M62,87.8c0,0.6-0.5,1.1-1.1,1.1H15.2c-0.6,0-1.1-0.5-1.1-1.1V42.2c0-0.6,0.5-1.1,1.1-1.1h45.7c0.6,0,1.1,0.5,1.1,1.1V87.8z"/>
                        <path d="M84.8,5H39.2c-4,0-7.2,3.2-7.2,7.2V29h6V12.2c0-0.6,0.5-1.1,1.1-1.1h45.7c0.6,0,1.1,0.5,1.1,1.1v45.7c0,0.6-0.5,1.1-1.1,1.1 H74v6h10.8c3.9,0,7.2-3.2,7.2-7.2V12.2C92,8.2,88.8,5,84.8,5z"/>
                    </svg>
                </div>

                   <!-- Texto adicional -->
                <p class=" text-roboto-medium ">Ao copiar o código, abra o aplicativo do seu banco.<br>cadastrado no PIX e realize o pagamento.</p>
                
                <button onclick="copyPixCode()" class="btn btn-copy" style="width: 400px;">Copiar código</button>
                <p onclick=" sharePixCode()" class=" text-alertaSize15 mt-2">Compartilhar código</p>
                  <br>


            </div>
        </div>


            </div>

        </div>
    </div>
</div>
    
    
    <!-- Modal -->
<div class="modal fade" id="loading_modal" tabindex="-1" role="dialog" aria-labelledby="exceedLimitLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 p-4">
            <!-- Cabeçalho do Modal -->
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <div class="modal-body">
            <div class="qr-code-section">
    
                
                <div style="text-align: center; margin-top: 20px;">
    <img src="https://media.tenor.com/2hNqKj3ArX8AAAAi/loading.gif" width="100" height="100">
    <p>Carregando QR Code...</p>
</div>


                <br>
                <br>
            </div>
        </div>


            </div>

        </div>
    </div>
    
@endif

    @if ($Payable_Balance == 1 && $cash_in_hand_overflow && $wallet?->balance < 0 && $cash_in_hand_overflow_store_amount < $wallet?->collected_cash)
        <script>
        // Abrir o modal automaticamente ao carregar a página
        document.addEventListener("DOMContentLoaded", function() {
            $('#pagamento_pix').modal('show');
        });
    </script>
<!-- Modal -->
<div class="modal fade" id="pagamento_pix" tabindex="-1" role="dialog" aria-labelledby="exceedLimitLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3 p-4">
            <!-- Cabeçalho do Modal -->
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <div class="modal-body">
            <div class="qr-code-section">
            
                <!-- QR Code -->
                <img style="
    height: 180px;
" src="https://i.ibb.co/1dkTjzF/1200px-TAR-Exclamation-icon-svg-1.png" alt="QR Code" class="img-fluid rounded mb-3 qr-code-img">
            
                <!-- Texto adicional -->
                <p class=" titulosInterBoldColorBlack "> Sua conta está suspensa temporariamente!</p>

                   <!-- Texto adicional -->
                <p style=" padding-left: 150px; padding-right: 150px; " class=" titulosInterMediumAviso">O limite do valor de recebimentos das vendas do app no caixa da loja foi excedido Por favor realize o pagamento do valor devido, para continuar recebendo pedidos no aplicativo.</p>
                
                                <div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;">
    <img src="https://media.tenor.com/2hNqKj3ArX8AAAAi/loading.gif" width="100" height="100">
    <p>Carregando QR Code...</p>
</div>

                
<a  onclick="carregarPagamento2('{{ $wallet->collected_cash }}', '{{ $wallet->vendor_id }}')">
    <button class="btn btn-copy mt-4" style="width: 400px;">Pagar Noga Foods</button>
</a>
                <br>
                <br>
            </div>
        </div>


            </div>

        </div>
    </div>
</div>
     @endif
     
    @if (env('APP_MODE')=='demo')
    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="initial-hidden">
                <div class="loading-inner">
                    <img width="200" src="{{asset('/assets/admin/img/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>
{{--loader--}}

<!-- Builder -->
@include('layouts.vendor.partials._front-settings')
<!-- End Builder -->

<!-- JS Preview mode only -->
@include('layouts.vendor.partials._header')
@include('layouts.vendor.partials._sidebar')
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
@yield('content')

<!-- End Content -->

    <!-- Footer -->
@include('layouts.vendor.partials._footer')
<!-- End Footer -->


    <div class="modal fade" id="toggle-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-ok-button" class="btn btn--primary min-w-120 confirm-Toggle" data-dismiss="modal">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">
                                {{translate("Cancel")}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-status-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-status-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-status-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-status-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-status-ok-button" class="btn btn--primary min-w-120 confirm-Status-Toggle" data-dismiss="modal">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">
                                {{translate("Cancel")}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <h2>
                                    <i class="tio-shopping-cart-outlined"></i> {{translate('messages.You have new order, Check Please.')}}
                                </h2>
                                <hr>
                                <button  class="btn btn-primary check-order" onclick="pauseAudio()">{{translate('messages.Ok, let me check')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="{{asset('/assets/admin')}}/js/custom.js"></script>
<script src="{{asset('/assets/admin')}}/js/firebase.min.js"></script>
<!-- JS Implementing Plugins -->

@stack('script')

<!-- JS Front -->
<script src="{{asset('/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('/assets/admin')}}/js/toastr.js"></script>
<script src="{{asset('/assets/admin')}}/js/emogi-area.js"></script>
<script src="{{asset('/assets/admin/js/owl.min.js')}}"></script>
<script src="{{asset('/assets/admin/js/app-blade/vendor.js')}}"></script>
<script src="{{asset('/assets/admin/js/metodo-de-pagamento.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>



{!! Toastr::message() !!}
<script src="{{asset('/assets/admin/intltelinput/js/intlTelInput.min.js')}}"></script>

@if ($errors->any())

<script>
    "use strict";
    @foreach ($errors->all() as $error)
    toastr.error('{{ translate($error) }}', Error, {
        CloseButton: true,
        ProgressBar: true
    });
    @endforeach
</script>
@endif

@stack('script_2')
<audio id="myAudio">
    <source src="{{asset('/assets/admin/sound/notification_new.mp3')}}" type="audio/mpeg">
</audio>
    <script src="{{asset('/assets/admin/js/view-pages/common.js')}}"></script>

<script>
var audio = document.getElementById("myAudio");
var isPlaying = false; // Controla se o som está ativo
var interval; // Timer para repetição
var targetDuration = 600; // 10 minutos em segundos
var durationPlayed = 0; // Tempo total de reprodução

function playAudio() {
    audio.play();
    if (!isPlaying) {
        isPlaying = true;

        // Inicia a repetição do som com intervalo de 3 segundos
        interval = setInterval(function () {
            audio.currentTime = 0; // Reseta o áudio para o início
            audio.play().catch((err) => console.error("Erro ao tocar o áudio:", err));
        }, 3000); // 3 segundos de intervalo
    }
}

function pauseAudio() {
    isPlaying = false;
    clearInterval(interval); // Cancela o intervalo de repetição
    audio.pause(); // Para o som atual
    audio.currentTime = 0; // Reseta o áudio para o início
}
    
"use strict";


    $(window).on('load', function(){
        $('main > .container-fluid.content').prepend($('#renew-badge'));
    })



    $(document).on('ready', function(){
        // $('body').css('overflow','')
        $(".direction-toggle").on("click", function () {
            if($('html').hasClass('active')){
                $('html').removeClass('active')
                setDirection(1);
            }else {
                setDirection(0);
                $('html').addClass('active')
            }
        });
        if ($('html').attr('dir') === "rtl") {
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

        function setDirection(status) {
            if (status === 1) {
                $("html").attr('dir', 'ltr');
                $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                $("html").attr('dir', 'rtl');
                $(".direction-toggle").find('span').text('Toggle LTR')
            }
            $.get({
                    url: '{{ route('vendor.site_direction') }}',
                    dataType: 'json',
                    data: {
                        status: status,
                    },
                    success: function() {
                    },

                });
            }
        });


    function route_alert(route, message) {
        Swal.fire({
            title: '{{ translate('messages.Are you sure?') }}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    $('.form-alert').on('click',function (){
        let id = $(this).data('id')
        let message = $(this).data('message')
        Swal.fire({
            title: '{{ translate('messages.Are you sure?') }}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    })


    function set_filter(url, id, filter_by) {
        let nurl = new URL(url);
        nurl.searchParams.set(filter_by, id);
        location.href = nurl;
    }

    @php($fcm_credentials = \App\CentralLogics\Helpers::get_business_settings('fcm_credentials'))
    let firebaseConfig = {
        apiKey: "{{isset($fcm_credentials['apiKey']) ? $fcm_credentials['apiKey'] : ''}}",
        authDomain: "{{isset($fcm_credentials['authDomain']) ? $fcm_credentials['authDomain'] : ''}}",
        projectId: "{{isset($fcm_credentials['projectId']) ? $fcm_credentials['projectId'] : ''}}",
        storageBucket: "{{isset($fcm_credentials['storageBucket']) ? $fcm_credentials['storageBucket'] : ''}}",
        messagingSenderId: "{{isset($fcm_credentials['messagingSenderId']) ? $fcm_credentials['messagingSenderId'] : ''}}",
        appId: "{{isset($fcm_credentials['appId']) ? $fcm_credentials['appId'] : ''}}",
        measurementId: "{{isset($fcm_credentials['measurementId']) ? $fcm_credentials['measurementId'] : ''}}"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {

messaging
    .requestPermission()
    .then(function () {
        return messaging.getToken()

    }).then(function (response) {
        @php($store_id=\App\CentralLogics\Helpers::get_store_id())
        subscribeTokenToTopic(response, "store_panel_{{$store_id}}_message");
    }).catch(function (error) {
        console.error('Error getting permission or token:', error);


        
        alert('Ative as Notificações do Navegador!\n\nPara garantir que você receba todos os alertas de novos pedidos em tempo real, é obrigatório habilitar as notificações do navegador.\n\nSiga os passos abaixo para ativar:\n1. Acesse as Configurações do seu navegador.\n2. Encontre a opção Notificações.\n3. Certifique-se de que as notificações estão ativadas para este site.');
    });
}

@php(
    $key = \App\Models\BusinessSetting::where('key', 'push_notification_service_file_content')->first()
)

async function subscribeTokenToTopic(token, topic) {
    const url = 'https://portal.nogafoods.com.br/api/v1/subscribeToTopic';
    fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ token: token, topic: topic })
    }).then(response => {
        if (response.status < 200 || response.status >= 400) {
            return response.text().then(text => {
                throw new Error(`Error subscribing to topic: ${response.status} - ${text}`);
            });
        }
        console.log(`Subscribed to "${topic}"`);
    }).catch(error => {
        console.error('Subscription error:', error);
    });

}








    
   









    function getUrlParameter(sParam) {
            let sPageURL = window.location.search.substring(1);
            let sURLletiables = sPageURL.split('&');
            for (let i = 0; i < sURLletiables.length; i++) {
                let sParameterName = sURLletiables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1];
                }
            }
        }

        function conversationList() {
            $.ajax({
                url: "{{ route('vendor.message.list') }}",
                success: function(data) {
                    $('#conversation-list').empty();
                    $("#conversation-list").append(data.html);
                    let user_id = getUrlParameter('user');
                    $('.customer-list').removeClass('conv-active');
                    $('#customer-' + user_id).addClass('conv-active');
                }
            })
        }

        function conversationView() {
            let conversation_id = getUrlParameter('conversation');
            let user_id = getUrlParameter('user');
            let url= '{{url('/')}}/store-panel/message/view/'+conversation_id+'/' + user_id;
            $.ajax({
                url: url,
                success: function(data) {
                    $('#view-conversation').html(data.view);
                }
            })
        }
        @php($order_notification_type = \App\Models\BusinessSetting::where('key', 'order_notification_type')->first())
        @php($order_notification_type = $order_notification_type ? $order_notification_type->value : 'firebase')
        let order_type = 'all';
        messaging.onMessage(function (payload) {
            if(payload.data.order_id && payload.data.type === 'new_order'){
                @if(\App\CentralLogics\Helpers::employee_module_permission_check('order') && $order_notification_type == 'firebase')
                    order_type = payload.data.order_type
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                @endif
            }else if(payload.data.type === 'message'){
            let conversation_id = getUrlParameter('conversation');
            let user_id = getUrlParameter('user');
            let url= '{{url('/')}}/store-panel/message/view/'+conversation_id+'/' + user_id;
            $.ajax({
                url: url,
                success: function(data) {
                    $('#view-conversation').html(data.view);
                }
            })
            toastr.success('{{ translate('messages.New message arrived') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });

            if($('#conversation-list').scrollTop() === 0){
                conversationList();
            }
        }
        });

        @if(\App\CentralLogics\Helpers::employee_module_permission_check('order') && $order_notification_type == 'manual')
        setInterval(function () {
            $.get({
                url: '{{route('vendor.get-store-data')}}',
                dataType: 'json',
                success: function (response) {
                    let data = response.data;
                    if (data.new_pending_order > 0) {
                        order_type = 'pending';
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                    else if(data.new_confirmed_order > 0)
                    {
                        order_type = 'confirmed';
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                },
            });
        }, 10000);
        @endif

        $('.check-order').on('click',function (){
            console.log(order_type);
            console.log('check-order');
            console.log('clicado');
            if(order_type){
                location.href = '{{url('/')}}/store-panel/order/list/'+order_type;
            }
        });
        startFCM();
        conversationList();
        if(getUrlParameter('conversation')){
            conversationView();
        }


    const inputs = document.querySelectorAll('input[type="tel"]');
            inputs.forEach(input => {
                window.intlTelInput(input, {
                    initialCountry: "{{$countryCode}}",
                    utilsScript: "{{ asset('/assets/admin/intltelinput/js/utils.js') }}",
                    autoInsertDialCode: true,
                    nationalMode: false,
                    formatOnDisplay: false,
                });
            });


            function keepNumbersAndPlus(inputString) {
                let regex = /[0-9+]/g;
                let filteredString = inputString.match(regex);
            return filteredString ? filteredString.join('') : '';
            }

            $(document).on('keyup', 'input[type="tel"]', function () {
                $(this).val(keepNumbersAndPlus($(this).val()));
                });


</script>

<script>
    function carregarPagamento2(valorDevido, vendedorID) {
        $('#alerta_conta_suspensa').modal('hide');
        $('#pagamento_pix').modal('hide');
        $('#loading_modal').modal('show');
        buscarQrCode(valorDevido, vendedorID);
    
    }

// Função para gerar um ID aleatório
function gerarIdAleatorio() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}

function buscarQrCode(valorDevido, vendedorID) {

    $.ajax({
        url: "https://portal.nogafoods.com.br/api/v1/gerarPIXQrCodeDiretoContaNogaF",
        type: 'POST', 
        dataType: 'json', 
        contentType: 'application/json', 
        processData: false,
        data: JSON.stringify({  
            store_id: vendedorID,
            email_do_cliente: "v@gmail.com", 
            produtos: [ 
                {
                    id: gerarIdAleatorio(), 
                    title: "Noga Foods - Pagamento",
                    description: "Noga Foods Delivery",
                    quantity: 1,
                    unit_price: valorDevido  
                }
            ]
        }), 
        success: function (data) {
            $('#loading_modal').modal('hide');
            // Pegando o valor da imagem base64 de 'qrcodepix'
             var qrcodePixBase64 = data.qrcodepix;
             var imgElement = document.querySelector('.qrcode-pix');
            imgElement.src = qrcodePixBase64;
            var copyPaste = data.qrcodepixCopyPaste;
            var inputElement = document.querySelector('.copyPaste');
            inputElement.value = copyPaste;
            
            $('#pagamento_pix-1').modal('show');
            startVerificarPagamento(vendedorID, data.paymentId);
        }, 
        error: function(error) { 
            alert("Não foi possível obter os dados");
            console.error(error);
            document.getElementById('loadingSpinner').style.display = 'none';
        }
    });
}


let paymentCheckInterval;
function startVerificarPagamento(vendedorID, paymentId) {
    // Verifica a cada 5 segundos após o sucesso do AJAX
    paymentCheckInterval = setInterval(function () {
        verificarPagamento(vendedorID, paymentId);
    }, 5000);
}


function verificarPagamento(vendedorID, paymentId) {
    console.error('aguardando pagamento');
    const url = `https://portal.nogafoods.com.br/api/v1/buscaDadosDePagamento/${paymentId}`;
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status === 'approved') {
                console.log("PAGAMENTO APROVADO");
                debitaDaContaDoLojistaSaldoAPagar(vendedorID);
                clearInterval(paymentCheckInterval); 
                console.error('pagamento aprovado e travado a consulta');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao verificar o pagamento:', error);
            alert('Erro ao verificar o pagamento');
        }
    });
}

function debitaDaContaDoLojistaSaldoAPagar(storeId) {
    const url = 'https://portal.nogafoods.com.br/api/v1/debitaSaldoApagarDoLojista';
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            vendorId: storeId,
        }),
        success: function(data) {
            $('#pagamento_pix-1').modal('hide');
            $('#modalsucesso').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Erro ao debitaDaContaDoLojistaSaldoAPagar', error);
            alert('Erro ao debitaDaContaDoLojistaSaldoAPagar');
        }
    });
}



    function copyPixCode() {
        var copyText = document.getElementById("pixCode");
        copyText.select();
        document.execCommand("copy");
        alert("Código Pix copiado!");
    }


function copyPixCode() {
  const pixCodeElement = document.getElementById('pixCode');
  const pixCode = pixCodeElement.textContent || pixCodeElement.value;
  if (!navigator.clipboard) {
    const textArea = document.createElement('textarea');
    textArea.value = pixCode;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);
    alert('Código Pix copiado para a área de transferência (Método alternativo)!');
  } else {
    navigator.clipboard.writeText(pixCode).then(() => {
      alert('Código Pix copiado para a área de transferência!');
    }).catch(err => {
      console.error('Erro ao copiar o código Pix: ', err);
    });
  }
}

function sharePixCode() {
  const pixCodeElement = document.getElementById('pixCode');
  const pixCode = pixCodeElement.textContent || pixCodeElement.value;
  
  if (navigator.share) {
    navigator.share({
      title: 'Código Pix | NogaFoods',
      text: `${pixCode}`,
    })
    .then(() => {
      console.log('Código Pix compartilhado com sucesso!');
    })
    .catch((error) => {
      console.error('Erro ao compartilhar o código Pix:', error);
    });
  } else {
    alert('Compartilhamento não suportado neste navegador. Tente copiar o código.');
  }
}


</script>


<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
