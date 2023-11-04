<?php

namespace App\Http\Controllers;

use App\Http\Requests\BecomeTutorRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Constants;

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

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'result' => false,
                'status' => 400,
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
            ]);
        }
        $user = $this->user_repo->findUserByEmail($credentials['email']);

        return response()->json([
            'result' => true,
            'status' => 200,
            'message' => 'Login successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $request)
    {
        list($user, $token) = $this->user_service->register($request->toArray());
        
        return response()->json([
            'result' => true,
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
            'result' => true,
            'status' => 200,
            'message' => 'logout successfully',
        ]);
    }

    public function getUserById($id)
    {
        $user = $this->user_repo->findUserById($id);

        if (!$user) {
            return response()->json([
                'result' => false,
                'status' => 404,
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
            'user' => $user,
        ]);
    }

    public function registTutor(BecomeTutorRequest $request)
    {
        $input = $request->all();

        \DB::beginTransaction();

        try{

            $user = $this->user_repo->findUserById($input['id']);

            if (!$user || !$user['status_cd'] == Constants::CD_IN_PROGRESS) {
                return response()->json([
                    'result' => false,
                    'status' => 404,
                    'message' => 'Không tìm thấy người dùng'
                ], 403);
            }

            $new_user = $this->user_service->registTutor($input);       
            
            \DB::commit();  

            return response()->json([
                'result' => true,
                'status' => 200,
                'user' => $new_user,
            ]);

            
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function getListTutor(Request $request) 
    {
        $input = $request->all();

        
    }
}