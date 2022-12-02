<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Socialite;
use Google_Client;
use Google_Service_People;

class GoogleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function redirect()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return Socialite::driver('google')->setScopes(['openid', 'email', 'profile', 'https://www.googleapis.com/auth/admin.directory.user', 'https://www.googleapis.com/auth/admin.directory.user.readonly', 'https://www.googleapis.com/auth/cloud-platform'])->redirect();
        }else{
            return redirect()->to('/admin/dashboard');
        }        
    }

    public function index()
    {

        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $user = Socialite::driver('google')->setScopes(['openid', 'email', 'profile', 'https://www.googleapis.com/auth/admin.directory.user', 'https://www.googleapis.com/auth/admin.directory.user.readonly', 'https://www.googleapis.com/auth/cloud-platform'])->stateless()->user();

            $google_client_token = [
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
                'expires_in' => $user->expiresIn
            ];

            session(["token" => $google_client_token]);

            $response = Http::withToken(json_encode($google_client_token['access_token']))->get('https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=500&orderBy=email&query=email%3Amx*')->json();

            $ultima_cuenta = Http::withToken(json_encode($google_client_token['access_token']))->get("https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=1&orderBy=email&sortOrder=DESCENDING&query=email%3Amxa_0*")->json();

            return response()->view('cuentas-google.show', ["cuentas" => $response["users"], 'ultima_cuenta' => $ultima_cuenta["users"][0]]);
        }else{
            return redirect()->to('/admin/dashboard');
        }             

    }
    

    public function addCuenta(Request $request)
    {
        $token = session("token");

        $response = Http::withToken($token['access_token'])
            ->post(
                'https://admin.googleapis.com/admin/directory/v1/users',
                [
                    "name" => [
                        "givenName" => $request->nombre,
                        "familyName" => $request->apellidos
                    ],

                    "password" => "nuevo123",
                    "primaryEmail" => $request->correo . "@uptradingexperts.com"
                ]
            );

        $bitacora_id = session('bitacora_id');
    
        $log = new Log;

        $log->tipo_accion = "Inserción";
        $log->tabla = "Cuenta Google" . $request->correo . "@uptradingexperts.com";
        $log->bitacora_id = $bitacora_id;
    
        $log->save();
        
        $response = Http::withToken(json_encode($token['access_token']))->get('https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=500&orderBy=email&query=email%3Amx*')->json();

        $ultima_cuenta = Http::withToken(json_encode($token['access_token']))->get("https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=1&orderBy=email&sortOrder=DESCENDING&query=email%3Amxa_0*")->json();


        return response($response['users']);
    }

    public function editCuenta(Request $request)
    {
        $token = session("token");

        $response = Http::withToken($token['access_token'])
            ->put(
                "https://admin.googleapis.com/admin/directory/v1/users/$request->id",
                [
                    "name" => [
                        "givenName" => $request->nombre,
                        "familyName" => $request->apellidos
                    ],

                    "primaryEmail" => $request->correo . "@uptradingexperts.com"
                ]
            );

        $response = Http::withToken(json_encode($token['access_token']))->get('https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=500&orderBy=email&query=email%3Amx*')->json();

        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Cuenta Google" . $request->correo . "@uptradingexperts.com";
        $log->bitacora_id = $bitacora_id;

        $log->save();

        return response($response['users']);
    }

    public function generarCuentas(Request $request)
    {
        $token = session("token");

        $ultima_cuenta = Http::withToken(json_encode($token['access_token']))->get("https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=1&orderBy=email&sortOrder=DESCENDING&query=email%3Amxa_0*")->json();

        $correoComp = $request->correo;

        $correoArr = explode("_", $correoComp);
        $correo = explode("@", $correoArr[1]);

        for ($i=1; $i <= 10; $i++) { 
            
            $numCorreo = $correo[0] + $i;
            $numCorreo = str_pad($numCorreo, 5, "0", STR_PAD_LEFT);

            $response = Http::withToken($token['access_token'])
                ->post(
                    'https://admin.googleapis.com/admin/directory/v1/users',
                    [
                        "name" => [
                            "givenName" => 'Cliente',
                            "familyName" => 'Uptrading'
                        ],

                        "password" => "nuevo123",
                        "primaryEmail" => "mxa_" . $numCorreo . "@uptradingexperts.com"
                    ]
                );

            $ultimo_correo = "mxa_" . $numCorreo . "@uptradingexperts.com";
        }

        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Inserción";
        $log->tabla = "Cuenta Google" . $request->correo . "@uptradingexperts.com";
        $log->bitacora_id = $bitacora_id;

        $log->save();

        $response = Http::withToken(json_encode($token['access_token']))->get('https://admin.googleapis.com/admin/directory/v1/users?customer=my_customer&domain=uptradingexperts.com&maxResults=500&orderBy=email&query=email%3Amx*')->json();

        $data = array(
            "correos" => $response['users'],
            "ultimo_correo" => $ultimo_correo
        );
        
        return response($data);
    }
}