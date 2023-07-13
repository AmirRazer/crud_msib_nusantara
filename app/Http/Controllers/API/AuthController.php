<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

// new GuzzleHttp\Client;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {

         

       $request->validate([
            'name' => 'required|string',
            'email'=> 'required|string|email|unique:users',
            'password' => 'required|string|min:8'
       ]);

       $user = User::create([
        'name' => $request->name,
        'email'=> $request->email,
        'password' =>Hash::make($request->password)
       ]);

       $token = $user->createToken('auth-token')->plainTextToken;

       return response()->json([
        'data' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer'
       ]);

    }
    public function login(Request $request)
    {
        
        


        $request->validate([
            
            'email'=> 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        if (!Auth::attempt(
            $request->only('email', 'password')
        )){
            return response()->json([
                'message' => 'Unauthenticed'
            ], 401);
        }
        $user = user::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
           ]);
    }
    public function logout(Request $request)
    {
       $request->user()->tokens()->delete();
       return response()->json([
        'msg' => 'Logout success'
       ]);
    }
    public function loginApi(Request $request)
    {
        
        $email = $request->email;
        $password = $request->password;

        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'headers' => [
                'Authorization' => 'Bearer ' . session()->get('token.access_token'),
                'Accept' => 'application/json'
            ],
            'query' => [
                'email' => $email,
                'password' => $password
            ],

        ]);

        $result = json_decode((string)$response->getBody(), true);
        return dd($result);
    }
}
