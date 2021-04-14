<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\JWTException;

class Users extends Controller
{   
    private $user;

    public function __construct(User $user){
        $this->user = $user;  
        $this->middleware(['jwt.auth','auth:api'], ['except' => ['login', 'register']]);  
        
    }
    public function register(Request $request){
        $user = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'avatar'=>$request->get('avatar'),
        ]);

        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully',
            'data'=>$user
        ]);
    }
    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
