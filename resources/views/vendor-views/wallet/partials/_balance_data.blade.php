
<div class="row g-3">
    <?php

    $disbursement_type = \App\Models\BusinessSetting::where('key' , 'disbursement_type')->first()->value ?? 'manual';
    $min_amount_to_pay_store = \App\Models\BusinessSetting::where('key' , 'min_amount_to_pay_store')->first()->value ?? 0;

    $wallet_earning =  round($wallet->total_earning - ($wallet->total_withdrawn + $wallet->pending_withdraw) , 8);

    if($wallet->balance > 0 && $wallet->collected_cash > 0 ){
        $adjust_able = true;
    } elseif($wallet->collected_cash != 0 && $wallet_earning !=  0 ){
        $adjust_able = true;
    } elseif($wallet->balance ==  $wallet_earning  ){
        $adjust_able = false;
    }
    else{
        $adjust_able = false;
    }

    $digital_payment = App\CentralLogics\Helpers::get_business_settings('digital_payment');
    $digital_payment  = $digital_payment['status'];

    ?>

    @if($adjust_able ==  true  || ($disbursement_type ==  'manual' && $wallet->balance > 0) || $wallet->balance < 0 || ( $wallet->collected_cash > 0 && $min_amount_to_pay_store <= $wallet->collected_cash ))
            <?php
            $col_size = true;
            ?>
    @endif



    <!-- Store Wallet Balance -->
    <div class="col-md-12">
        <div class="row g-3">
            <!-- Panding Withdraw Card Example -->
            <div class="col-sm-{{ isset($col_size) == true ? '3' :'4' }}">
                <div class="resturant-card shadow--card-2" >
                    <h4 class="title">{{\App\CentralLogics\Helpers::format_currency($wallet->collected_cash)}}</h4>

                    <div class="d-flex gap-1 align-items-center">
                                    <span class="subtitle">{{translate('messages.Cash_in_Hand')}}
                                    </span>

                        <span class="form-label-secondary text-danger d-flex"
                              data-toggle="tooltip" data-placement="right"
                              data-original-title="{{ translate('The_total_amount_you’ve_received_from_the_customer_in_cash_(Cash_on_Delivery)')}}"><img
                                src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                alt="{{ translate('messages.Take_Picture_For_Completing_Delivery') }}"> </span>
                        <img class="resturant-icon" src="{{asset('/public/assets/admin/img/transactions/image_total89.png')}}" alt="public">

                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-sm-{{ isset($col_size)  == true ? '3' :'4' }}">
                <div class="resturant-card shadow--card-2">
                    <h4 class="title">{{\App\CentralLogics\Helpers::format_currency($wallet->balance > 0 ? $wallet->balance: 0 )}}</h4>
                    <span class="subtitle">{{translate('messages.withdraw_able_balance')}}</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/transactions/image_w_balance.png')}}" alt="public">
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-sm-{{ isset($col_size) == true ? '6' :'4' }}">
                <div class="resturant-card shadow--card-2">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>

                            @if ($wallet->balance > 0)
                                <h4 class="title">{{\App\CentralLogics\Helpers::format_currency(abs($wallet_earning))}}</h4>


                                @if( $wallet->balance ==  $wallet_earning )

                                    <span class="subtitle">{{ translate('messages.Withdrawable_Balance') }}</span>
                                @else
                                    <span class="subtitle">{{ translate('messages.Balance') }}
                                            <small>{{translate('Unadjusted')}} </small>
                                        </span>
                                @endif

                            @else
                                <h4 class="title">{{\App\CentralLogics\Helpers::format_currency(abs($wallet->collected_cash))}}</h4>
                                <span class="subtitle">{{  translate('messages.Payable_Balance')}}</span>

                            @endif


                        </div>

                        @if($wallet->balance > 0  &&  $wallet->balance > $wallet->collected_cash  )
                            <div class="d-flex gap-2 flex-wrap">
                                @if ($adjust_able ==  true )
                                    <a class="btn btn--primary d-flex gap-1 align-items-center text-nowrap"  href="javascript:" data-toggle="modal" data-target="#Adjust_wallet">{{translate('messages.Adjust_with_wallet')}}

                                        <span class="form-label-secondary d-flex"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="{{ translate('Adjust_the_withdrawable_balance_&_unadjusted_balance_with_your_wallet_(Cash_in_Hand)_or_click_‘Request_Withdraw’')}}">
                                        <i class="tio-info-outined"> </i>

                                        </span>

                                    </a>
                                @endif

                                @if ($disbursement_type ==  'manual'  )
                                    <a  href="javascript:"

                                       @if(count($withdrawal_methods) !== 0 )
                                           class="btn btn--primary d-flex gap-1 align-items-center text-nowrap"
                                       data-toggle="modal" data-target="#balance-modal"
                                        @else
                                            class="btn btn--primary d-flex gap-1 align-items-center text-nowrap withdrawal-methods-disable"
                                        data-message="{{translate('Withdraw_methods_are_not_available')}}"
                                       @endif
                                    >{{translate('messages.request_withdraw')}}

                                        <span class="form-label-secondary  d-flex"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="{{ translate('As_you_have_more_‘Withdrawable_Balance’_than_‘Cash_in_Hand’,_you_need_to_request_for_withdrawal_from_Admin')}}">
                                            <i class="tio-info-outined"> </i> </span>
                                    </a>
                                @endif
                            </div>
                        @elseif($wallet->balance < 0 ||  ($wallet->collected_cash > 0 && $wallet->collected_cash  > $wallet->balance )     )
                            <div class="d-flex gap-2 flex-wrap">

                                @if ($adjust_able ==  true )
                                    <a class="btn btn--primary d-flex gap-1 align-items-center text-nowrap"  href="javascript:" data-toggle="modal" data-target="#Adjust_wallet">{{translate('messages.Adjust_with_wallet')}}

                                        <span class="form-label-secondary  d-flex"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="{{ translate('As_you_have_more_‘Cash_in_Hand’_than_‘Withdrawable_Balance,’_you_need_to_pay_the_Admin')}}"> <i class="tio-info-outined"> </i> </span> </span>
                                    </a>
                                @endif

                                @if ($min_amount_to_pay_store <= $wallet->collected_cash )
                                    <a
                                    @if ( $digital_payment != 1)
                                    class="btn btn--secondary d-flex gap-1 align-items-center text-nowrap payment-warning"  href="javascript:"

                                    @else

                                    class="btn btn--primary d-flex gap-1 align-items-center text-nowrap"  href="javascript:" onclick="carregarPagamento2('{{ $wallet->collected_cash }}', '{{ $wallet->vendor_id }}')"
                                   
                                    @endif

                                    >{{translate('messages.Pay_Now')}}

                                        <span class="form-label-secondary  d-flex"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="{{ translate('Adjust_the_payable_&_withdrawable_balance_with_your_wallet_(Cash_in_Hand)_or_click_‘Pay_Now’.')}}"> <i class="tio-info-outined"> </i> </span> </span></a>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="row g-3">
            <!-- Panding Withdraw Card Example -->
            <div class="col-sm-4">
                <div class="resturant-card  bg--3" >
                    <h4 class="title">{{\App\CentralLogics\Helpers::format_currency($wallet->pending_withdraw)}}</h4>
                    <span class="subtitle">{{translate('messages.pending_withdraw')}}</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/transactions/image_pending.png')}}" alt="public">
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-sm-4">
                <div class="resturant-card  bg--2">
                    <h4 class="title">{{\App\CentralLogics\Helpers::format_currency($wallet->total_withdrawn)}}</h4>
                    <span class="subtitle">{{translate('messages.Total_Withdrawn')}}</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/transactions/image_withdaw.png')}}" alt="public">
                </div>
            </div>


            <!-- Pending Requests Card Example -->
            <div class="col-sm-4">
                <div class="resturant-card  bg--1">
                    <h4 class="title">{{\App\CentralLogics\Helpers::format_currency($wallet->total_earning)}}</h4>
                    <span class="subtitle">{{translate('messages.total_earning')}}</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/transactions/image_total89.png')}}" alt="public">
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="btn btn--circle btn-soft-danger text-danger"><i class="tio-clear"></i></span>
                </button>
            </div>

            <form action="{{route('vendor.wallet.withdraw-request')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="">
                        <select class="form-control" id="withdraw_method" name="withdraw_method" required>
                            <option value="" selected disabled>{{translate('Select_Withdraw_Method')}}</option>
                            @foreach($withdrawal_methods as $item)
                                <option value="{{$item['id']}}">{{$item['method_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="" id="method-filed__div">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">{{translate('messages.amount')}}:</label>
                        <input type="number" name="amount"  step="0.01"
                               value="{{abs($wallet->balance)}}"
                               class="form-control h--45px" id="" min="1" max="{{abs($wallet->balance)}}">
                    </div>
                </div>
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn--reset" data-dismiss="modal">{{translate('messages.cancel')}}</button>
                    <button type="submit" id="submit_button" class="btn btn--primary">{{translate('messages.Submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;">
    <img src="https://media.tenor.com/2hNqKj3ArX8AAAAi/loading.gif" width="100" height="100">
    <p>Carregando QR Code...</p>
</div>

<!-- Modal Bootstrap -->
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
            document.getElementById('loadingSpinner').style.display = 'none';
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


<!-- Estilos adicionais (CSS) -->
<style>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">                 
  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">

                <div class="form-group">
                    <p  id="hiddenValue"> </p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="reset_btn" type="reset" data-dismiss="modal" class="btn btn-secondary" >{{ translate('Close') }} </button>
            </div>
        </div>
    </div>
</div>






<!-- Content Row -->
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <ul class="nav nav-tabs page-header-tabs pb-2">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('store-panel/wallet') ?'active':''}}"  href="{{ route('vendor.wallet.index') }}">{{translate('messages.withdraw_request')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{Request::is('store-panel/wallet/wallet-payment-list') ?'active':''}}" href="{{route('vendor.wallet.wallet_payment_list')}}"  aria-disabled="true">{{translate('messages.Payment_history')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{Request::is('store-panel/wallet/disbursement-list') ?'active':''}}" href="{{route('vendor.wallet.getDisbursementList')}}"  aria-disabled="true">{{translate('messages.Next_Payouts')}}</a>
                    </li>
                </ul>

            </div>
