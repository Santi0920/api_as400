<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;   
use Illuminate\Support\Facades\Hash;    
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
             

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User    ::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $accessToken = $user->createToken('authToken'); 

        $token = $accessToken->accessToken;
        
        $expirationDate = Carbon::now()->addYears(4000);
        $tokenId = $accessToken->token->id;

        DB::table('oauth_access_tokens')->where('id', $tokenId)->update([
            'expires_at' => $expirationDate,
        ]);

        return response([
            'user' => $user,
            'access_token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);
    
        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Credenciales inválidas.'], 401);
        }
    
        $user = auth()->user();
        $accessToken = $user->createToken('authToken'); 

        $token = $accessToken->accessToken;
        
        $expirationDate = Carbon::now()->addYears(4000);
        $tokenId = $accessToken->token->id;
        

        DB::table('oauth_access_tokens')->where('id', $tokenId)->update([
            'expires_at' => $expirationDate,
        ]);
    
        return response(['user' => $user, 'access_token' => $token]);
    }
    
}
