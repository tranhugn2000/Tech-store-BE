<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Client\AuthService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService)
    {        
        $this->middleware('auth.jwt', ['except' => ['login', 'refresh']]);
        $this->authService = $authService;
    }

    public function register(Request $request){
        try {
            $data = $request->all();
            $data['role'] = config('constant.role.client');
            $responseData = $this->authService->register($data);
            if ($responseData) {
                return response()->json([
                    'status' => 0,
                    'message' =>  __('api.success'),
                ], 200);
            }
            return response()->json([
                'status' => 1,
                'message' => __('api.bad_request'),
            ], 400);
        }
        catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } 
    }
    public function login(Request $request){
        $data = $request->all();
        $refreshToken = Str::random(64);
        $refreshTokenExpried = date('Y-m-d H:i:s' , strtotime('+7 day'));
        $responseData = $this->authService->login($data, $refreshToken, $refreshTokenExpried);
        if (!$responseData || !$token = $responseData->access_token) {
            return response()->json([
                'status' => 1,
                'message' => __('api.login_failed'),
            ],401);
        }

        return response()->json([
            'status' => 0,
            'message' => __('api.success'),
            'data' => [
                'token' => $token,
                'auth' => $responseData->name,
                'refresh_token' => $refreshToken,
                'refresh_token_expried' => $refreshTokenExpried
            ]
        ],200);
    }
    public function refresh(Request $request){
        $data = $request->all();
        $user = $this->authService->getUserByRefreshToken($data);
        if (!$user) {
            return response()->json([
                'status' => 1,
                'message' =>  __('api.refresh_token.not_found'),
            ],400);
        }
        JWTAuth::setToken($user->access_token)->invalidate();
        $token = JWTAuth::fromUser($user);
        $responseData = $this->authService->updateRefreshToken($user->id, $token);
            return response()->json([
                'status' => 0,
                'message' =>  '',
                'token' => $token,
                'refresh_token' => $responseData->refresh_token,
            ],200);
        return response()->json([
            'status' => 1,
            'message' =>  __('api.refresh_token.not_found'),
        ],401);
    }
}
