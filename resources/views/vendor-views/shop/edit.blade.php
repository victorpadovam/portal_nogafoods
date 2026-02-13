
@extends('layouts.vendor.app')
@section('title',translate('messages.edit_store'))



@push('css_or_js')
<style>
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 1020;
    background: #fff;

    /* quebra o padding do container */
    margin-left: -15px;
    margin-right: -15px;
    padding: 12px 24px;
}


/* Evita o conteúdo "passar por baixo" */
.content.container-fluid {
    padding-top: 10px;
}

.page-header-title {
    text-align: left !important;
    flex: 1;
}

</style>

    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Custom styles for this page -->
     <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
<div class="content container-fluid">

        <form action="{{ route('vendor.shop.update') }}" method="post" enctype="multipart/form-data">
        
        @csrf

<div class="page-header sticky-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        
        <!-- TÍTULO (sempre à esquerda) -->
        <h2 class="page-header-title m-0 text-left">
            {{ translate('messages.edit_store_info') }}
        </h2>

        <!-- AÇÕES (direita) -->
        <div class="d-flex gap-2">
    
            <button class="btn btn-primary">
                Atualizar
            </button>
        </div>

    </div>
</div>












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

        @php
            $logo = $shop->logo;
            // remove o domínio
            $logo = str_replace('https://portal.nogafoods.com.br/', '', $logo);
        @endphp


        <div class="logo position-relative image-edit-wrapper ">
            <img
                class="editable-image onerror-image"
                     src="https://portal.nogafoods.com.br/storage/app/public/store/{{ $logo }}"
                alt="{{ $shop->name }} Logo"
            >

            <button type="button" class="edit-image-btn" title="Alterar logo">
                <i class="fa fa-pen"></i>
            </button>

            <input
                type="file"
                name="logo"
                class="image-file-input"
                accept=".png,.jpg,.jpeg"
                hidden
            >
        </div>
    </div>

    <!-- CAPA -->
<div class="d-flex flex-column __custom-upload-img">
        <span class="image-label">Capa Loja (2:1)</span>

        <div class="logo position-relative image-edit-wrapper">
        <img
            class="cover-img editable-image onerror-image"
        src="{{ asset('storage/store/' . $shop->destaque) }}"
            alt="{{ $shop->name }} Capa"
        >


            <button type="button" class="edit-image-btn" title="Alterar capa">
                <i class="fa fa-pen"></i>
            </button>

            <input
                type="file"
                name="destaque"
                class="image-file-input"
                accept=".png,.jpg,.jpeg"
                hidden
            >
        </div>
    </div>

</div>

{{-- IMAGEM NO TOPO --}}



            {{-- FORMULÁRIO --}}
            <div class="row g-3">

                {{-- Nome --}}
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input 
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ $shop->name }}"
                    >
                </div>

                {{-- CNPJ --}}
                <div class="col-md-6">
                    <label class="form-label">CNPJ</label>
                    <input 
                        type="text"
                        name="cnpj"
                        class="form-control"
                        value="{{ $shop->cnpj }}"
                    >
                </div>

                {{-- Razão Social --}}
                <div class="col-md-6">
                    <label class="form-label">Razão Social</label>
                    <input 
                        type="text"
                        name="social_reason"
                        class="form-control"
                        value="{{ $shop->social_reason }}"
                    >
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input 
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ $shop->email }}"
                    >
                </div>

                {{-- Telefone --}}
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input 
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ $shop->phone }}"
                    >
                </div>

                {{-- Zona --}}
                <div class="col-md-6">
                    <label class="form-label">Zona</label>
                    <select name="zone_id" class="form-control">
                        <option value="">
                            {{ $shop?->zone?->name ?? translate('zone_deleted') }}
                        </option>
                    </select>
                </div>

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
                        <input type="text" name="city" class="form-control" value="{{ $shop->city }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <input type="text" name="state" class="form-control" value="{{ $shop->state }}" >
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Endereço</label>
                        <input type="text"  name="address" class="form-control" value="{{ $shop->address }}" >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Número</label>
                        <input type="text" name="number" class="form-control" value="{{ $shop->number }}" >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="neighborhood" class="form-control" value="{{ $shop->neighborhood }}" >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep" class="form-control" value="{{ $shop->cep }}" >
                    </div>

                </div>
            </div>

            {{-- Mapa --}}
            <div class="col-lg-6">
                <div id="map" class="single-page-map border rounded" style="min-height: 300px;"></div>
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
                <input 
                    type="text" 
                    class="form-control"
                    name="socialNetwork"
                    value="{{ $shop->socialNetwork }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Telefone 1</label>
                <input 
                    type="text" 
                    name="firstPhone"
                    class="form-control"
                    value="{{ $shop->firstPhone }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Telefone 2</label>
                <input 
                    type="text" 
                    class="form-control"
                    name="secondPhone"
                    value="{{ $shop->secondPhone }}"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">WhatsApp</label>
                <input 
                    type="text" 
                     name="whatsapp"
                    class="form-control"
                    value="{{ $shop->whatsapp }}"
                    
                >
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
                        <option
                            value="{{ $module->id }}"
                            @selected($module->id == $shop->module_id)
                        >
                            {{ $module->module_name }}
                        </option>
                    @endforeach
                </select>
            </div>

                       <div class="col-md-6">
                <label class="form-label">Tipo de negócio</label>
                <input type="text" class="form-control" name="businessType"
                    value="{{ $shop->businessType }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Serviço do Estabelecimento</label>
                <input type="text" class="form-control" name="serviceType"
                    value="{{ $shop->serviceType }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Possui serviço de entrega?</label>
                <input type="text" class="form-control" name="hasDeliveryService"
                    value="{{ $shop->hasDeliveryService ? 'Sim' : 'Não' }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Taxa média de entrega</label>
                <input type="text" class="form-control" name="deliveryFee"
                    value="{{ $shop->deliveryFee }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Possui conta no Mercado Pago?</label>
                <input type="text" class="form-control"  name="hasMercadoPago"
                    value="{{ $shop->hasMercadoPago ? 'Sim' : 'Não' }}" >
            </div>




            <div class="col-md-6">
                <label class="form-label">Métodos de pagamento</label>

                @if(count($pagamentos) > 0)
                    <ul class="ps-3 mb-0">
                        @foreach($pagamentos as $pagamento)
                            <li>{{ $pagamento }}</li>
                        @endforeach
                    </ul>
                @else
                    <input type="text" class="form-control" value="Não informado" readonly>
                @endif
            </div>


            <div class="col-md-6">
                <label class="form-label">Pagamento padrão</label>
                <input type="text" class="form-control" name="pagamento_padrao"
                    value="{{ $shop->pagamento_padrao ? 'Sim' : 'Não' }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Valor do pedido mínimo</label>
                <input type="text" class="form-control" name="minimumOrder"
                    value="{{ $shop->minimumOrder }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Tempo aproximado para delivery</label>
                <input type="text" class="form-control" name="tempo_aproximada_para_delivery"
                    value="{{ $shop->tempo_aproximada_para_delivery }}" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Tempo aproximado para retirada</label>
                <input type="text" class="form-control" name="tempo_aproximada_para_retirada"
                    value="{{ $shop->tempo_aproximada_para_retirada }}" >
            </div>

            
        </div>
    </div>
</div>
          
 

{{-- FECHA qualquer row anterior antes disso --}}

<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title m-0">HORÁRIOS DE FUNCIONAMENTO</h5>
            </div>

            <div class="card-body">
                @foreach ($horarios as $dia => $dados)
                    <div class="border rounded mb-3">

                        {{-- HEADER DO DIA --}}
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
                            <strong class="text-uppercase">{{ $dia }}</strong>

                            <div class="d-flex gap-3">
                                <label class="d-flex align-items-center gap-1 m-0">
                                    <input type="radio"
                                           name="horarios[{{ $dia }}][enabled]"
                                           value="1"
                                           {{ $dados['enabled'] ? 'checked' : '' }}>
                                    Aberto
                                </label>

                                <label class="d-flex align-items-center gap-1 m-0">
                                    <input type="radio"
                                           name="horarios[{{ $dia }}][enabled]"
                                           value="0"
                                           {{ !$dados['enabled'] ? 'checked' : '' }}>
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
                                            <input type="time"
                                                   class="form-control"
                                                   name="horarios[{{ $dia }}][intervals][{{ $i }}][start]"
                                                   value="{{ $intervalo['start'] }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Até</span>
                                            <input type="time"
                                                   class="form-control"
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
                <input 
                    type="text" 
                    class="form-control"
                    name="contractReceiveOption"
                    value="{{ $shop->contractReceiveOption }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Como você conheceu a Noga Foods?</label>
                <input 
                    type="text" 
                    class="form-control"
                    name="howYouMeetNogaFoods"
                    value="{{ $shop->howYouMeetNogaFoods }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Você recebeu a visita do nosso representante?</label>
                <input 
                    type="text" 
                    class="form-control"
                    name="receivedOurRepresentative"
                    value="{{ $shop->receivedOurRepresentative }}"
                    
                >
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
                <input 
                    type="text" 
                    class="form-control"
                     name="ownerName"
                    value="{{ $shop->ownerName }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Cargo na empresa</label>
                <input 
                    type="text" 
                    class="form-control"
                     name="ownerCargo"
                    value="{{ $shop->ownerCargo }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">E-mail</label>
                <input 
                    type="email" 
                    class="form-control"
                     name="ownerEmail"
                    value="{{ $shop->ownerEmail }}"
                    
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Telefone</label>
                <input 
                    type="text" 
                    class="form-control"
                    name="ownerPhone"
                    value="{{ $shop->ownerPhone }}"
                    
                >
            </div>

            <div class="col-md-12">
                <label class="form-label">Observações</label>
                <textarea 
                    class="form-control" 
                    name="observation"
                    rows="3"
                    
                >{{ $shop->observation }}</textarea>
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

                                <img
                                    class="editable-image onerror-image"
                                    src="{{ asset('storage/store/documents/' . $shop->owenerDocumentoComFotoFrente) }}"
                                    alt="{{ $shop->name }} frente"
                                >

                                <button
                                    type="button"
                                    class="edit-image-btn"
                                    title="Alterar documento (frente)"
                                >
                                    <i class="fa fa-pen"></i>
                                </button>

                                <input
                                    type="file"
                                    name="owenerDocumentoComFotoFrente"
                                    class="image-file-input"
                                    accept=".png,.jpg,.jpeg"
                                    hidden
                                >
                            </div>
                        </li>

                        <!-- DOCUMENTO VERSO -->
                        <li class="d-flex align-items-center gap-3">
                            <span><strong>Foto (verso)</strong></span>

                            <div class="image-edit-wrapper">

                                <img
                                    class="editable-image onerror-image"
                                    src="{{ asset('storage/store/documents/' . $shop->owenerDocumentoComFotoVerso) }}"
                                    alt="{{ $shop->name }} verso"
                                >

                                <button
                                    type="button"
                                    class="edit-image-btn"
                                    title="Alterar documento (verso)"
                                >
                                    <i class="fa fa-pen"></i>
                                </button>

                                <input
                                    type="file"
                                    name="owenerDocumentoComFotoVerso"
                                    class="image-file-input"
                                    accept=".png,.jpg,.jpeg"
                                    hidden
                                >
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
                        <span class="ml-1">{{translate('messages.owner_info')}}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resturant--info-address">
                        <div class="avatar avatar-xxl avatar-circle avatar-border-lg">
                            <img class="avatar-img onerror-image" data-onerror-image="{{asset('public/assets/admin/img/160x160/img1.jpg')}}"

                            src="{{ \App\CentralLogics\Helpers::get_image_helper(
                                $shop->vendor,'image',
                                asset('storage/app/public/vendor').'/'.$shop->vendor->image ?? '',
                                asset('public/assets/admin/img/160x160/img1.jpg'),
                                'vendor/'
                            ) }}"
                            alt="Image Description">
                        </div>
                        <ul class="address-info address-info-2 list-unstyled list-unstyled-py-3 text-dark">
                            <li>
                                <h5 class="name">{{$shop->vendor->f_name}} {{$shop->vendor->l_name}}</h5>
                            </li>
                            <li>
                                <i class="tio-call-talking nav-icon"></i>
                                <span class="pl-1"><a href="mailto:{{$shop->vendor->email}}">{{$shop->vendor->email}}</a> </span>
                            </li>
                            <li>
                                <i class="tio-email nav-icon"></i>
                                <span class="pl-1"> <a href="tel:{{$shop->vendor->phone}}"> {{$shop->vendor->phone}} </a></span>
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
                        <span class="ml-1">{{translate('messages.Business_Plan')}}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resturant--info-address">
                        <ul class="address-info address-info-2 list-unstyled list-unstyled-py-3 text-dark">

                        @if ($shop->store_business_model == 'commission')
                        <li>
                            <span>  <strong>{{translate('messages.Business_Plan')}}</span></strong>  <span>:</span> &nbsp; {{ translate($shop->store_business_model) }}
                        </li>
                        @php($admin_commission = \App\Models\BusinessSetting::where(['key' => 'admin_commission'])->first()?->value)
                        <li>
                            <span><strong>{{translate('messages.Commission_percentage')}}</strong></span> <span>:</span> &nbsp; {{ $shop->comission > 0 ?  $shop->comission : $admin_commission }} %
                        </li>
                        @elseif ($shop->store_business_model == 'subscription')
                            <li>
                                <span>  <strong>{{translate('messages.Business_Plan')}}</span></strong>  <span>:</span> &nbsp; {{ translate($shop->store_business_model) }} &nbsp;
                                @if ($shop?->store_sub_update_application->is_trial == '1')
                                <small> <span class="badge badge-info" >{{ translate('messages.Free_trial')}}</span> </small>
                                @endif
                            </li>
                            <li>
                                <span> <strong>{{translate('messages.Package_name')}}</strong></span> <span>:</span> &nbsp; {{ $shop?->store_sub_update_application?->package?->package_name  ?? translate('Pacakge_not_found!!!')}}
                            </li>
                        @elseif ($store->store_business_model == 'unsubscribed')
                            <li>
                                <span>  <strong>{{translate('messages.Business_Plan')}}</span></strong>  <span>:</span> &nbsp; {{ translate($shop->store_business_model) }} &nbsp;

                                <small> <span class="badge badge-danger" >{{ translate('messages.Expired')}}</span> </small>

                            </li>
                            <li>
                                <span> <strong>{{translate('messages.Package_name')}}</strong></span> <span>:</span> &nbsp; {{ $shop?->store_sub_update_application?->package?->package_name  ?? translate('Pacakge_not_found!!!')}}
                            </li>
                            @else
                                <li>
                                <span>  <strong>{{translate('messages.Business_Plan')}}</span></strong>  <span>:</span> &nbsp; {{ translate('Have_n’t_Selected_Yet.') }}
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
     </div>

            </div>
            {{-- <div class="mt-3 justify-content-end btn--container">
                <a class="btn btn--danger text-capitalize" href="{{route('vendor.shop.view')}}">{{translate('messages.cancel')}}</a>
                <button type="submit" class="btn btn--primary text-capitalize" id="btn_update">{{translate('messages.update')}}</button>
            </div> --}}
        </form>
    </div>



@endsection

@push('script_2')

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8" ></script>
    

    <script>
$(document).ready(function () {

            const myLatLng = { lat: {{$shop->latitude}}, lng: {{$shop->longitude}} };
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
                title: "{{$shop->name}}",
            });
        }

    $('.edit-image-btn').on('click', function () {
        const wrapper = $(this).closest('.image-edit-wrapper');
        wrapper.find('.image-file-input').click();
    });

    $('.image-file-input').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (!['image/png','image/jpeg','image/jpg'].includes(file.type)) {
            alert('Formato inválido');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        const wrapper = $(this).closest('.image-edit-wrapper');
        const image = wrapper.find('.editable-image');

        reader.onload = function (e) {
            image.attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });

});
</script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/vendor/shop-edit.js"></script>
@endpush
