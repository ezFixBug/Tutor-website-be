<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\CreateCourseRequest;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $course_service;
    private $user_repo;
    private $course_repo;

    public function __construct(CourseService $course_service, UserRepositoryInterface $user_repo, CourseRepositoryInterface $course_repo)
    {
        $this->course_service = $course_service;
        $this->user_repo = $user_repo;
        $this->course_repo = $course_repo;
    }

    public function createCourse(CreateCourseRequest $request, $user_id)
    {
        try {
            \DB::beginTransaction();

            $user = $this->user_repo->findUserById($user_id);

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy người dùng'
                ], 403);
            }

            if ($user['role_cd'] != Constants::CD_ROLE_TUTOR) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Vui lòng đăng ký trở thành gia sư!'
                ], 403);
            }

            $input = $request->all();
            $input['user_id'] = $user_id;

            $this->course_service->createCourse($input);

            \DB::commit();

            return response()->json([
                'result' => true,
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserCourses($user_id)
    {
        $user = $this->user_repo->findUserById($user_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy người dùng'
            ], 403);
        }

        $courses = $this->course_repo->getCoursesByUserId($user_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'courses' => $courses,
        ]);
    }

    public function getDetailCourse($course_id)
    {
        $course = $this->course_repo->getCourseById($course_id);

        if (!$course) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy khóa học'
            ], 403);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
            'course' => $course,
        ]);
    }

    public function editCourse(CreateCourseRequest $request)
    {
        try {
            \DB::beginTransaction();

            $input = $request->all();

            $course = $this->course_repo->getCourseById($input['id']);

            if (!$course) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy khóa học'
                ], 403);
            }

            $input['user_id'] = $course['user_id'];

            $this->course_service->updateCourse($input);

            \DB::commit();

            return response()->json([
                'result' => true,
                'status' => 200,
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCourse($course_id)
    {
        try {
            \DB::beginTransaction();

            $course = $this->course_repo->getcourseById($course_id);

            if (!$course) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy bài viết'
                ], 404);
            }

            $this->course_repo->deleteCourse($course_id);
            
            \DB::commit();
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
