<?php

namespace App\Services\Client;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthService
{
    protected $user;
    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register($data){
        if (User::where('email', '=', $data['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => __('api.email_exists'),
            ]);
        }
        $data['password'] = Hash::make($data['password']);
        $user = $this->user->create($data);
        return $user;
    }
    
    public function login($data, $refreshToken, $refreshTokenExpried){
        if (isset($data)) {
            $user = $this->user->where('email', '=', $data['email'])->where('role', config('constant.role.client'))->first();
                if (!Hash::check($data['password'], $user->password)) {
                    return false;
                }
                $user->refresh_token = $refreshToken;
                $user->refresh_token_expried = $refreshTokenExpried;
                $user->access_token = JWTAuth::fromUser($user);
                $user->update();
            return $user;
        }
        return false;
    }

    public function getUserByRefreshToken($data)
    {
        $user = User::where('refresh_token', $data['refresh_token'])->first();
        return $user;
    }

    public function updateRefreshToken($id, $token)
    {
        $user = User::where('id', $id)->first();
        DB::transaction(function () use ($user, $token) {
            $refreshToken = Str::random(64);
            $user->refresh_token = $refreshToken;
            $user->refresh_token_expried = date('Y-m-d H:i:s', strtotime('+30 day'));
            $user->access_token = $token;
            $user->update();
        });
        return $user;
    }
}
                    