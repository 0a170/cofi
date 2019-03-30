<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /** 
     * Log in a a user
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Http\Response 
     */
    public function login(Request $request) 
    {
        if (!Auth::check()) {
            $http = new \GuzzleHttp\Client;
            // $headers = ['Accept' => 'application/json'];
            $response = $http->post(config('services.passport.login_endpoint'), [
                // 'headers' => $headers,
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request['username'],
                    'password' => $request['password'],
                    'scope' => '*',
                ]
            ]);

            return $response->getBody();
        } else {
            return response()->json('Already logged in');
        }

    }

    public function register(Request $request) 
    {
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json($user);
    }

    public function logout() 
    {
        dd('here');
        if (Auth::check()) {
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json('Logged Out Successfully', 200);
        } else {
            return response()->json('Issue logging out, try again', 500);
        }
    }
}
