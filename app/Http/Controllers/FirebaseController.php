<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;


class FirebaseController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

    public function subscribeToTopic(Request $request)
    {
      
        $request->validate([
            'token' => 'required|string',
            'topic' => 'required|string',
        ]);

        $token = $request->input('token');
        $topic = $request->input('topic');

        try {
            
            if($this->messaging){
                $this->messaging->subscribeToTopic($topic, $token);
                return response()->json(['message' => 'Successfully subscribed to topic'], 200);
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
//   public static function getAccessToken()
//     {
//         $serviceAccountPath = public_path('prod/noga-foods-brasil-9af7a7db642b.json');
     
//         $credentials = json_decode(file_get_contents($serviceAccountPath), true);
          
//         $now = time();
//         $payload = [
//             'iss' => $credentials['client_email'],
//             'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//             'aud' => $credentials['token_uri'],
//             'exp' => $now + 3600,
//             'iat' => $now,
//         ];
       

//         $jwt = JWT::encode($payload, $credentials['private_key'], 'RS256');
        

//         $client = new Client();
//         $response = $client->post($credentials['token_uri'], [
//             'form_params' => [
//                 'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
//                 'assertion' => $jwt,
//             ]
//         ]);
     
//         $accessToken = json_decode($response->getBody(), true)['access_token'] ?? null;
    
//          return response()->json(['access_token' => $accessToken]);
//     }
}

