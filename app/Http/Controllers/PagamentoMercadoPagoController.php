<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CredenciaisMercadoPago;
use App\CentralLogics\Helpers;
use App\Models\PagamentoMercadoPago;
use Illuminate\Support\Str; 
use App\Models\MercadoPagoConfigLojista;
use App\Models\Item;
use App\Models\Order;
use App\Models\Review;
use App\Models\Category;
use App\CentralLogics\StoreLogic;
use App\CentralLogics\CategoryLogic;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\ProductLogic;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class PagamentoMercadoPagoController extends Controller
{
    
    public $access_token_vendedor;
    
    
    
    public function get_latest_products_deeplink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'category_id' => 'required',
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if (!$request->hasHeader('zoneId')) {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $zone_id = $request->header('zoneId');
        $type = $request->query('type', 'all');
        $product_id = $request->query('product_id')??null;
        $min = $request->query('min_price');
        $max = $request->query('max_price');

        $items = ProductLogic::get_latest_products($zone_id, $request['limit'], $request['offset'], $request['store_id'], $request['category_id'], $type,$min,$max,$product_id);
        $items['categories'] = $items['categories'];
        $items['products'] = Helpers::product_data_formatting($items['products'], true, false, app()->getLocale());
        return response()->json($items, 200);
    }
    
        public function get_product_deplink($id)
{
      try {
            $item = Item::withCount('whislists')->with(['tags','reviews','reviews.customer'])->active()
            ->when(config('module.current_module_data'), function($query){
                $query->module(config('module.current_module_data')['id']);
            })
            ->when(is_numeric($id),function ($qurey) use($id){
                $qurey-> where('id', $id);
            })
            ->when(!is_numeric($id),function ($qurey) use($id){
                $qurey-> where('slug', $id);
            })
            ->first();
            $store = StoreLogic::get_store_details($item->store_id);
            if($store)
            {
                $category_ids = DB::table('items')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->selectRaw('categories.position as positions, IF((categories.position = "0"), categories.id, categories.parent_id) as categories')
                ->where('items.store_id', $item->store_id)
                ->where('categories.status',1)
                ->groupBy('categories','positions')
                ->get();

                $store = Helpers::store_data_formatting($store);
                $store['category_ids'] = array_map('intval', $category_ids->pluck('categories')->toArray());
                $store['category_details'] = Category::whereIn('id',$store['category_ids'])->get();
                $store['price_range']  = Item::withoutGlobalScopes()->where('store_id', $item->store_id)
                ->select(DB::raw('MIN(price) AS min_price, MAX(price) AS max_price'))
                ->get(['min_price','max_price']);
            }
            $item = Helpers::product_data_formatting($item, false, false, app()->getLocale());
            $item['store_details'] = $store;
            return response()->json($item, 200);
        } catch (\Exception $e) {
            dd($e->getLine());
            return response()->json([
                'errors' => ['code' => 'product-001', 'message' => translate('messages.not_found')]
            ], 404);
        }
}
    
    public function detalhesLoja(Request $request)
{
    // Valida a request para garantir que o store_id est«¡ presente
    $request->validate([
        'store_id' => 'required|integer|exists:stores,id',
    ]);

    // Busca todas as lojas que possuem o store_id informado
    $stores = Store::where('id', $request->store_id)->get();

    // Retorna os dados encontrados
    return response()->json([
        'success' => true,
        'data' => $stores
    ]);
}

    // public function geraTokenAutorizacaoEntreContasVinculadas(Request $request)
    // {
    //     $requestCode = $request->query('code');
    //     $requestState = $request->query('state');
    //     if (!empty($requestCode) && !empty($requestState)) {
    //         $code = trim($requestCode);
    //         $state = $requestState;
    //         $access_token = "APP_USR-3303584281305432-031118-f5c44ed02ff6e3835bdea7a76f6e86cd-1071567284";
    //         $redirect_uri = "https://portal.nogafoods.com.br/api/v1/mercadopago-autoriza-contas";

    //         $curl = curl_init();
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => 'https://api.mercadopago.com/oauth/token?client_secret=' . $access_token . '&code=' . $code . '&redirect_uri=' . $redirect_uri,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => 'client_secret=' . $access_token . '&grant_type=authorization_code&code=' . $code . '&redirect_uri=' . $redirect_uri,
    //             CURLOPT_HTTPHEADER => array(
    //                 'accept: application/json',
    //                 'content-type: application/x-www-form-urlencoded',
    //             ),
    //         ));
    //         $response = curl_exec($curl);
    //         curl_close($curl);
    //         $obj = json_decode($response, true);
            
    //         if (isset($obj['error']) && $obj['error'] === 'invalid_grant' && strpos($obj['message'], 'expired') !== false) {
    //             return $this->refreshToken($state);
    //         }
            
    //         if (isset($obj['access_token'])) {
    //             $buscaALoja = Store::where('vendor_id', $state)->first();
    //             $verificaSeJaExiste = CredenciaisMercadoPago::where('store_id', $buscaALoja->id)->first();
    //             if ($verificaSeJaExiste == null) { 
    //                   $dados = [
    //                     'access_token' => $obj['access_token'],
    //                     'token_type' => $obj['token_type'],
    //                     'expires_in' => $obj['expires_in'],
    //                     'scope' => $obj['scope'],
    //                     'user_id' => $obj['user_id'],
    //                     'refresh_token' => $obj['refresh_token'],
    //                     'public_key' => $obj['public_key'],
    //                     'live_mode' => $obj['live_mode'],
    //                     'state' => $state,
    //                     'store_id' => $buscaALoja->id,
    //                 ];
    //                 CredenciaisMercadoPago::create($dados);
    //             }
               
                
    //             return  "old_access_token: " .  $obj['access_token'];
    //         }
    //     }
    // }

    public function refreshToken($idDoUsuarioLogado) {
        $find = CredenciaisMercadoPago::where('state', '=', $idDoUsuarioLogado)->first();
        $access_token = "APP_USR-3303584281305432-031118-f5c44ed02ff6e3835bdea7a76f6e86cd-1071567284";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'client_secret' => $access_token,
                'grant_type' => 'refresh_token',
                'refresh_token' => $find->refresh_token,
            )),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $obj = json_decode($response, true);
        
        if (isset($obj['access_token'])) {
            $buscaRegistro = CredenciaisMercadoPago::find($find->id);
            $buscaALoja = Store::where('vendor_id', $idDoUsuarioLogado)->first();

            $data = [
                'access_token' => $obj['access_token'],
                'token_type' => $obj['token_type'],
                'expires_in' => $obj['expires_in'],
                'scope' => $obj['scope'],
                'user_id' => $obj['user_id'],
                'refresh_token' => $obj['refresh_token'],
                'public_key' => $obj['public_key'],
                'live_mode' => $obj['live_mode'],
                'state' => $idDoUsuarioLogado,
                'store_id' => $buscaALoja->id,
            ];

            $buscaRegistro->update($data);
            
            return  "novo_access_token: " .  $obj['access_token'];
        } else {
            echo '<pre> erro no refreshToken';
            echo '</pre>';
        }
    }
    
    
     public function createPreference(Request $request) {
        $data = $request->all();
        $produtos = $data['produtos'];
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];        
        $email = $data['email'];
        $parcelas = $data['installments'];
        $idLoja = $data['store_id'];
  
        //verificaSeAutorizouCredencial
        $find = MercadoPagoConfigLojista::where('store_id', '=', $idLoja)->first();
        
        if (empty($find->access_token) && empty($find->public_key)) {
            return response()->json([
                'status' => 'metodo_de_pagamento_nao_configurado'
            ]);
        }
        
      
        
        $itens = [];
        $valorTotalSomaDeTodosProdutos = 0;
        foreach ($produtos as $produto) {
            $valorProduto = floatval($produto['unit_price']) * intval($produto['quantity']);
            $valorTotalSomaDeTodosProdutos += $valorProduto;
    
            $itens[] = [
                "id" => $produto['id'],
                "title" => $produto['title'],
                "quantity" => intval($produto['quantity']),
                "unit_price" => floatval($produto['unit_price'])
            ];
        }
        $valor = $valorTotalSomaDeTodosProdutos;
          $data = [
            'items' => $produtos,
            'payer' => [
                'name' => $nome,
                'surname' => $sobrenome,
                'email' => $email,
            ],
           'payment_methods' => [
                'installments' => $parcelas, 
                'excluded_payment_types' => [
                    [
                        'id' => 'ticket' 
                    ],
                    [
                        'id' => 'bank_transfer' 
                    ],
                ],
            ],
            'transaction_amount' => $valor,
        ];
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $find->access_token
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        curl_close($ch);

        if ($httpCode != 201) {
            return response()->json(['error' => 'Erro ao criar prefer«´ncia de pagamento'], $httpCode);
        }

        $responseData = json_decode($response, true);

        return response()->json([
            'status' => 'metodo_de_pagamento_configurado',
            'id' => $responseData['id'],
            'public_key_vendedor' => $find->public_key,
        ], 200);
    }
    

  
  

    // public function gerarTokenCartaoCredito($card_number, $security_code, $expiration_month, $expiration_year, $cardholder_name) {
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.mercadopago.com/v1/card_tokens",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => json_encode([
    //             "card_number" => $card_number,
    //             "security_code" => $security_code,
    //             "expiration_month" => $expiration_month,
    //             "expiration_year" => $expiration_year,
    //             "cardholder" => [
    //                 "name" => $cardholder_name
    //             ]
    //         ]),
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: Bearer APP_USR-3303584281305432-031118-f5c44ed02ff6e3835bdea7a76f6e86cd-1071567284", 
    //             "Content-Type: application/json"
    //         ),
    //     ));
    
    //     $response = curl_exec($curl);
    //     curl_close($curl);
    
    //     $data = json_decode($response);
        
    //     // Retorna o token gerado
    //     return $data->id;
    // }

public function alterarStatusPagamentoAprovado(Request $request) {
    $data = $request->all();
    $idLoja = $data['store_id'];
    $orderID = $data['order_id'];
    $paymentStatus = $data['payment_status'];
    
    $order = Order::where('store_id', $idLoja)->where('id', $orderID)->first();
    $buscaRegistro = Order::find($order->id);
    

    
$dataUpdate = [
    'payment_status' => $paymentStatus,
];
    
    $atualizou = $buscaRegistro->update($dataUpdate);

    
    return response()->json([
        'status' => 'status_alterado',
    ]);
}

    
    public function gerarPIXQrCodeComSplitDePagamento (Request $request) {
        $data = $request->all();
        $idLoja = $data['store_id'];
        
        
        $find = MercadoPagoConfigLojista::where('store_id', '=', $idLoja)->first();
        if (empty($find->access_token) && empty($find->public_key)) {
            return response()->json([
                'status' => 'metodo_de_pagamento_nao_configurado'
            ]);
        }
        

        $emailDoCliente = $data['email_do_cliente'];
        $produtos = $data['produtos'];
        $buscaComissaoDaLoja = Store::where('id', $idLoja)->first();
        $comissao = (int) filter_var($buscaComissaoDaLoja->comission, FILTER_SANITIZE_NUMBER_INT);
        // Processando a lista de produtos
        $itens = [];
        $valorTotalSomaDeTodosProdutos = 0;
        foreach ($produtos as $produto) {
            $valorProduto = floatval($produto['unit_price']) * intval($produto['quantity']);
            $valorTotalSomaDeTodosProdutos += $valorProduto;
    
            $itens[] = [
                "id" => $produto['id'],
                "title" => $produto['title'],
                "description" => $produto['description'],
                "quantity" => intval($produto['quantity']),
                "unit_price" => floatval($produto['unit_price'])
            ];
        }
        
        $valor                 = $valorTotalSomaDeTodosProdutos;
        $descricao             = "Pagamento PIX";
        $email_cliente         = $emailDoCliente;
        
        // $url_notificacao       = "https://portal.nogafoods.com.br/api/v1/handlePaymentNotification";
        
        $url_notificacao = "https://portal.nogafoods.com.br/api/v1/handlePaymentNotification?token_vendedor={$find->access_token}";

        $access_token_vendedor = $find->access_token;
        $payCreateId = $this->addPayment($valorTotalSomaDeTodosProdutos, $idLoja);
        $idempotencyKey = (string) Str::uuid();
        if ($payCreateId) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "transaction_amount": '.$valor.',
                "description": "'.$descricao.'",
                "payment_method_id": "pix",
                "payer": {
                    "email": "'.$email_cliente.'"
                },
                "binary_mode": true,
                "external_reference": "'.$payCreateId.'",
                "notification_url": "'.$url_notificacao.'",
                "additional_info": {
                     "items": '.json_encode($itens).'
                }
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $find->access_token,
                'Content-Type: application/json',
                'X-Idempotency-Key: ' . $idempotencyKey 
              ),
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);
            
            $dados_payment = json_decode($response);
            $qrcodepix     = "data:image/jpeg;base64,{$dados_payment->point_of_interaction->transaction_data->qr_code_base64}";
            $qrcodepixCopyPaste = $dados_payment->point_of_interaction->transaction_data->qr_code;
            $paymentId = $dados_payment->id;
            
            $payment = PagamentoMercadoPago::find($payCreateId); 
            if ($payment) {
                $payment->status = "qrcode-gerado";
                $payment->store_id = $idLoja;  
                $payment->payment_id = $paymentId;
                $payment->save(); 
            }
        
            return response()->json([
                'status' => 'metodo_de_pagamento_configurado',
                'qrcodepix' => $qrcodepix,
                'qrcodepixCopyPaste' => $qrcodepixCopyPaste,
                'paymentId' => $paymentId
            ]);
        }
    }
    
    public function gerarPIXQrCodeDiretoContaNogaF(Request $request) {
        $data = $request->all();
        //  return response()->json([
        //         'status' => 'metodo_de_pagamento_configurado',
        //         'data' => $data['produtos'][0]['id']
        //     ]);
            
        $idLoja = $data['store_id'];
        $access_token = 'APP_USR-3303584281305432-031118-f5c44ed02ff6e3835bdea7a76f6e86cd-1071567284';
        $public_key = 'APP_USR-a41589de-0dc2-494a-82a1-7676d5c1c856';
        $emailDoCliente = $data['email_do_cliente'];
        $produto = $data['produtos'];
        $itens[] = [
            "id" => $produto[0]['id'],
            "title" => $produto[0]['title'],
            "description" => $produto[0]['description'],
            "quantity" => intval($produto[0]['quantity']),
            "unit_price" => floatval($produto[0]['unit_price'])
        ];
        
       
        $valor                 = $produto[0]['unit_price'];
        $descricao             = "Pagamento PIX";
        $email_cliente         = $emailDoCliente;
        
        $url_notificacao = "https://portal.nogafoods.com.br/api/v1/handlePaymentNotification?token_vendedor={$access_token}";

        $idempotencyKey = (string) Str::uuid();
        $payCreateId = $this->addPayment($valor, $idLoja);
        if ($payCreateId) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "transaction_amount": '.$valor.',
                "description": "'.$descricao.'",
                "payment_method_id": "pix",
                "payer": {
                    "email": "'.$email_cliente.'"
                },
                "binary_mode": true,
                "external_reference": "'.$payCreateId.'",
                "notification_url": "'.$url_notificacao.'",
                "additional_info": {
                     "items": '.json_encode($itens).'
                }
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json',
                'X-Idempotency-Key: ' . $idempotencyKey 
              ),
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);
            
            $dados_payment = json_decode($response);
            $qrcodepix     = "data:image/jpeg;base64,{$dados_payment->point_of_interaction->transaction_data->qr_code_base64}";
            $qrcodepixCopyPaste = $dados_payment->point_of_interaction->transaction_data->qr_code;
            $paymentId = $dados_payment->id;
            
            $payment = PagamentoMercadoPago::find($payCreateId); 
            if ($payment) {
                $payment->status = "qrcode-gerado";
                $payment->store_id = $idLoja;  
                $payment->payment_id = $paymentId;
                $payment->save(); 
            }
        
            return response()->json([
                'status' => 'metodo_de_pagamento_configurado',
                'qrcodepix' => $qrcodepix,
                'qrcodepixCopyPaste' => $qrcodepixCopyPaste,
                'paymentId' => $paymentId
            ]);
        }
    }
    
    public function handlePaymentNotification(Request $request) { 
       
        $accessToken = $request->input('token_vendedor');
   
        $body = json_decode($request->getContent());

        
       if (isset($body->data->id)) {
           $id = $body->data->id;
           
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: ' . 'Bearer ' . $accessToken
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            
            $payment = json_decode($response);
            
            if (isset($payment->id)) {
                $paymentData = $this->getPaymentById($payment->id);

                if ($paymentData) {
                    $this->setStatusPayment($payment->id, $payment->status);
                }
            }
        }
    }
    
    public function getPaymentById($paymentId) {
        $payment = PagamentoMercadoPago::where('payment_id', $paymentId)->first();
        return $payment ? $payment : false;
    }
    
    public function setStatusPayment($paymentId, $status) {
        $payment = PagamentoMercadoPago::where('payment_id', $paymentId)->first();
        
        if ($payment) {
            $payment->status = $status;
            return $payment->save();
        }

        return false;
    }
    
    public function verificaStatusPagamento($idDoPagamento){
        $payment = PagamentoMercadoPago::where('payment_id', $idDoPagamento)->first();
    
        if ($payment) {
            return response()->json([
                'status' => $payment->status,
            ]);
        } else {
            return response()->json(['error' => 'Pagamento nÃ£o encontrado'], 404);
        }
    }

    
    
    public function addPayment($valor, $storeId) {
        $payment = new PagamentoMercadoPago();
        $payment->valor = $this->formatacaoMascaraDinheiroDecimal($valor);
        $payment->store_id = $storeId;
        $payment->status = "pending1";

        if ($payment->save()) {
            return $payment->id;
        } else {
            return false;
        }
    }

    public function mercadoPagoBackURlSuccess() {
        dd("Success");
        return view();
    }

    public function mercadoPagoBackURlFailure() {
        dd("Failure");
        return view();
    }

    public function mercadoPagoBackURlPending() {
        dd("Pending");
        return view();
    }
    
    public function formatacaoMascaraDinheiroDecimal($valorParaFormatar) {
        $tamanho = strlen($valorParaFormatar);
        $dados = str_replace(',', '.', $valorParaFormatar);
        if ($tamanho <= 6) {
            $dados = str_replace(',', '.', $valorParaFormatar);
        } else {
            if ($tamanho >= 8 && $tamanho <= 10) {
                $retiraVirgulaPorPonto = str_replace(',', '.',   $valorParaFormatar);
                $separaPorIndice  = explode('.',  $retiraVirgulaPorPonto);
                $dados  =  $separaPorIndice[0] . $separaPorIndice[1];
            }
        }

        return $dados;
    }
}
