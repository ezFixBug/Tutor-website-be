<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Auth;
use Illuminate\Http\Request;
use JWTAuth;

class AdminController extends Controller
{
    private $admin_user_repo;
    private $user_repo;
    private $course_repo;


    public function __construct(AdminUserRepositoryInterface $admin_user_repo, UserRepositoryInterface $user_repo, CourseRepositoryInterface $course_repo)
    {
        $this->admin_user_repo = $admin_user_repo;
        $this->user_repo = $user_repo;
        $this->course_repo = $course_repo;
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

    public function approveRequestTutor($user_id)
    {
        $user = $this->user_repo->findUserById($user_id);

        if (!$user) {
            return response()->json([
                'result' => false,
                'status' => 404,
                'message' => "User does not exist"
            ]);
        }

        $user['role_cd'] = Constants::CD_ROLE_TUTOR;
        $user['status_cd'] = Constants::CD_APPROVED;

        $this->user_repo->updateUser($user);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function getCourses(Request $request)
    {
        $input = $request->all();

        $courses = $this->admin_user_repo->getCourses($input);

        return response()->json([
            'result' => true,
            'status' => 200,
            'courses' => $courses,
        ]);
    }

    public function approveCourse($course_id)
    {
        $course = $this->course_repo->getCourseById($course_id);

        if (!$course) {
            return response()->json([
                'result' => false,
                'status' => 404,
                'message' => "Course does not exist"
            ]);
        }

        $course['status_cd'] = Constants::CD_ACCEPT;

        $this->course_repo->createOrUpdateCourse($course);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function getStatistics(Request $request)
    {
        $statistics = $this->admin_user_repo->getStatistics($request->all());

        return response()->json([
            'result' => true,
            'status' => 200,
            'statistics' => $statistics,
        ]);
    }

    public function getListUsers()
    {
        $users = $this->admin_user_repo->getListUsers();

        return response()->json([
            'result' => true,
            'status' => 200,
            'users' => $users,
        ]);
    }

    public function blockUser(Request $request, string $id)
    {
        $this->admin_user_repo->blockUserById($id, $request->all());

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }
    public function deleteUser(string $id)
    {
        $this->admin_user_repo->deleteUser($id);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function getListReportedTutors()
    {
        $users = $this->admin_user_repo->getListReportedTutors();

        return response()->json([
            'result' => true,
            'status' => 200,
            'users' => $users,
        ]);
    }
    public function getListReportedCourses()
    {
        $courses = $this->admin_user_repo->getListReportedCourses();

        return response()->json([
            'result' => true,
            'status' => 200,
            'courses' => $courses,
        ]);
    }

    public function blockCourse($courseId, Request $request)
    {
        $this->admin_user_repo->blockCourseById($courseId, $request->all());

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function getPayments(Request $request)
    {
        $payment = $this->admin_user_repo->getPayments($request->all());

        return response()->json([
            'result' => true,
            'status' => 200,
            'payments' => $payment
        ]);
    }
    public function getTotalRevenueWithUser(Request $request)
    {
        [$users_pending, $users_completed] = $this->admin_user_repo->getTotalRevenueWithUser($request->all());

        return response()->json([
            'result' => true,
            'status' => 200,
            'users_pending' => $users_pending,
            'users_completed' => $users_completed
        ]);
    }

    public function updateRevenue(Request $request){
        $this->admin_user_repo->updateRevenue($request->all());
        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }
}
