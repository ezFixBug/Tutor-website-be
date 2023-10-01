<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private $user_repo;

    private $user_service;

    public function __construct(UserRepository $user_repo, UserService $user_service)
    {
        $this->user_repo = $user_repo;
        $this->user_service = $user_service;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
                ]);
            }
            $user = $this->user_repo->findUserByEmail($credentials['email']);

            return response()->json([
                'status' => 200,
                'message' => 'Login successfully',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        list($user, $token) = $this->user_service->register($request->toArray());
        
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 200,
            'message' => 'logout successfully',
        ]);
    }
}