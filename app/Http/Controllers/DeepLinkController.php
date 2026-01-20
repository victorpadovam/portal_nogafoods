<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeepLinkController extends Controller
{
    public function handleDeepLink(Request $request, $productId, $storeId)
    {
        $userAgent = strtolower($request->header('User-Agent'));
        //https://app.nogafoods.com.br/product/1221/store/12

        // Deep Link do app
        $appDeepLink = "https://app.nogafoods.com.br/product/" . $productId . "/store/" . $storeId;
        
                     


        // Links para as lojas
        $playStoreUrl = "https://play.google.com/store/apps/details?id=com.nogafoods.delivery&hl=pt_BR";
        $appStoreUrl = "https://apps.apple.com/br/app/noga-foods-delivery/id6497331340";

        // Detecta a plataforma
        $isAndroid = strpos($userAgent, 'android') !== false;
        $isIOS = strpos($userAgent, 'iphone') !== false || strpos($userAgent, 'ipad') !== false || strpos($userAgent, 'ipod') !== false;

        // Define a loja correta
        $storeUrl = $isAndroid ? $playStoreUrl : ($isIOS ? $appStoreUrl : $playStoreUrl); // Padrão: Play Store
        

        return view('deeplink', [
            'appDeepLink' => $appDeepLink,
            'storeUrl' => $storeUrl
        ]);
    }
}