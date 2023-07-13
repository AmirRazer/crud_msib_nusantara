<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class LoginController extends Controller
{
    public function login(Request $request)
    {
      

        $response = Http::post('http://127.0.0.1:8000/api/login?',[
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token.access_token')
            ],
            'query' => [
                'email' => 'admin1@gmail.com',
                'password' => 'admin12345'
            ],
        ]);

        $result = json_decode((string)$response->getBody(), true);
        return dd($result);
        return view('login');
    }
}
