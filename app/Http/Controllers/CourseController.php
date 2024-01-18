<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\LikeRequest;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\CourseService;
use App\Traits\HandleLikeTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use HandleLikeTrait;
    
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
            ], 404);
        }

        $course['is_like'] = $this->checkLike($course_id, Auth::id());

        $this->course_repo->increaseViewsOfCourse($course);

        $course['is_register'] = $this->course_repo->isRegisterCourse($course_id);

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

    public function getCourses(Request $request)
    {
        $input = $request->all();

        $data = $this->course_repo->searchListCourse($input);

        $paginate = [
            'current_page' => $data['current_page'],
            'next_page' => $data['next_page_url'],
            'prev_page' => $data['prev_page_url'],
            'total_pages' => $data['last_page'],
            'total_count' => $data['total'],        
        ];

        return response()->json([
            'result' => true,
            'status' => 200,
            'courses' => $data['data'],
            'paginate' => $paginate,
        ]);  
    }

    public function hanleLike(LikeRequest $request)
    {
        $input = $request->all();

        $course = $this->course_repo->getCourseById($input['relation_id']);

        if (!$course) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy khóa học'
            ], 404);
        }
        
        $this->handleLike($input);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function registerCourse(Request $request)
    {
        $input = $request->all();
        $input['status_cd'] = Constants::CD_REGISTER_COURSE_APPROVE;
        $input['approve_at'] = Carbon::now();

        $register_course = $this->course_repo->saveOrUpdateRegisterCourse($input);

        return response()->json([
            'register_course' => $register_course,
            'result' => true,
            'status' => 200,
        ]);
    }

    public function approveCourse($register_course_id)
    {
        $register_course = $this->course_repo->findRegisterCourse($register_course_id);

        $register_course['approve_at'] = Carbon::now();
        $register_course['status_cd'] = Constants::CD_REGISTER_COURSE_APPROVE;

        $this->course_repo->saveOrUpdateRegisterCourse($register_course);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function getRegisterCourses($course_id)
    {
        $register_courses = $this->course_repo->getRegisterCourses($course_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'register_courses' => $register_courses
        ]);
    }

    public function getStudents($course_id) 
    {
        $students = $this->course_repo->getStudentsByCoureId($course_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'students' => $students
        ]);
    }

    public function getCoursesRegisted($user_id)
    {
        $courses = $this->course_repo->getCoursesRegisted($user_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'courses' => $courses
        ]);
    }
}
