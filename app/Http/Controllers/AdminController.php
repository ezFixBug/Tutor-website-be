<?php

namespace App\Http\Controllers;

use App\Repositories\AdminUserRepository;
use Auth;
use Illuminate\Http\Request;
use JWTAuth;

class AdminController extends Controller
{
    private $admin_user_repo;

    public function __construct(AdminUserRepository $admin_user_repo)
    {
        $this->admin_user_repo = $admin_user_repo;
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'result' => false,
                'status' => 400,
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác'
            ]);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
            'message' => 'Login successfully',
            'token' => $token
        ]);
    }

    public function getTutors(Request  $request)
    {
        $input = $request->all();

        $tutors = $this->admin_user_repo->getTutors($input);

        return response()->json([
            'result' => true,
            'status' => 200,
            'tutors' => $tutors,
        ]);  
    }
}
