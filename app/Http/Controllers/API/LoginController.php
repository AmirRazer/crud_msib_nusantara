<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class LoginController extends Controller
{
    // public function index()
    // {


    //     return view('index');
    // }
    // public function loginApi(Request $request)
    // {
        
    //     $email = $request->email;
    //     $password = $request->password;

    //     $response = Http::post('http://127.0.0.1:8000/api/login', [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . session()->get('token.access_token'),
    //             'Accept' => 'application/json'
    //         ],
    //         'query' => [
    //             'email' => $email,
    //             'password' => $password
    //         ],

    //     ]);

    //     $result = json_decode((string)$response->getBody(), true);
    //     return dd($result);
    // }
}
