<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        // return view('login');
//           $http = new GuzzleHttp\Client;
//            $response = $http->post('http://localhost:8000/api/register', [
//             'headers' => [
//                 'Authorization' => 'Bearer '.session()->get('token.access_token'),
//             ],
//             'query' => [
//                 'email' => $request->email,
//                 'password' => $request->password,
//             ],
//         ])
// ;

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
}
