<?php

namespace App\Repositories;

use App\Constants;
use App\Models\AdminUser;
use App\Models\FeedBack;
use App\Models\Post;
use App\Models\RequestTutor;
use App\Models\Course;
use App\Models\Payments;
use App\Models\Report;
use App\Models\User;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function getTutors($input)
    {
        $tutors = User::with('province', 'district', 'job')
            ->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('role_cd', Constants::CD_ROLE_TUTOR)
                        ->where('status_cd', Constants::CD_APPROVED);
                })->orWhere(function ($query) {
                    $query->where('role_cd', Constants::CD_ROLE_STUDENT)
                        ->where('status_cd', Constants::CD_IN_PROGRESS);
                });
            })
            ->when(isset($input['status_cd']), function ($query) use ($input) {
                if ($input['status_cd'] == Constants::CD_APPROVED) {
                    $query = $query->where('role_cd', Constants::CD_ROLE_TUTOR)
                        ->where('status_cd', Constants::CD_APPROVED);
                } else {
                    $query = $query->where('role_cd', Constants::CD_ROLE_STUDENT)
                        ->where('status_cd', Constants::CD_IN_PROGRESS);
                }
            })->get();

        return $tutors ? $tutors->toArray() : [];
    }

    public function getCourses($input)
    {
        $courses = Course::with('user')
            ->where('status_cd', $input['status_cd'])
            ->get();

        return $courses ? $courses->toArray() : [];
    }

    public function getStatistics()
    {
        $payments_course = Payments::select(
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('MONTH(created_at) as month')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        $data = [
            'total_tutor' => User::where('role_cd', Constants::CD_ROLE_TUTOR)->count(),
            'total_user' => User::where('role_cd', Constants::CD_ROLE_STUDENT)->count(),
            'total_feedback' => FeedBack::count(),
            'total_request' => RequestTutor::count(),
            'total_post' => Post::count(),
            'total_course' => Course::where('status_cd', Constants::CD_ACCEPT)->count(),
            'payments_course' => $payments_course?->map(function ($payment) {
                return [
                    'label' => $payment->month,
                    'value' => $payment->total_amount,
                ];
            })
        ];

        return $data;
    }

    public function getListUsers()
    {
        $users = User::get();

        return $users ? $users->toArray() : [];
    }

    public function blockUserById($id, $data)
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->status_cd = $data['status_cd'];
        $user->save();
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->delete();
    }

    public function getListReportedTutors()
    {
        $users = User::with(['reported' => function ($query) {
            $query->with('user');
        }])
            ->whereHas('reported')
            ->get();

        return $users ? $users->toArray() : [];
    }

    public function getListReportedCourses()
    {
        $courses = Course::with([
            'reported' => function ($query) {
                $query->with('user');
            },
            'user'
        ])->where('status_cd', '!=', 3)
            ->whereHas('reported')
            ->get();

        return $courses ? $courses->toArray() : [];
    }

    public function blockCourseById($id, $data)
    {
        $course = Course::find($id);

        if (!$course) {
            return false;
        }

        $course->status_cd = $data['status_cd'];
        $course->save();
    }

    public function getPayments($data)
    {
        $builder = Payments::with(['user']);

        if(isset($data['start_date']) && isset($data['end_date'])) {
            $builder = $builder->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        }

        $payments = $builder->get();

        $payments_course = $payments->filter(function ($payment) {
            return $payment->payment_type == Constants::PAYMENT_COURSE;
        })->map(function ($payment) {
            $payment_course = $payment;
            $payment_course->register_course = $payment->registerCourse;
            $payment_course->register_course->course = $payment->registerCourse->course;
            $payment_course->register_course->course->user = $payment->registerCourse->course->user;

            return $payment_course;
        })?->toArray();

        $payment_offer = $payments->filter(function ($payment) {
            return $payment->payment_type == Constants::PAYMENT_TUTOR;
        })->map(function ($payment) {
            $payment_offer = $payment;
            $payment_offer->register_offer = $payment->registerOffer;
            $payment_offer->register_offer->request = $payment->registerOffer->request;

            return $payment_offer;
        })?->toArray();

        return [
            'payment_course' => array_values($payments_course), 
            'payment_tutor' => array_values($payment_offer),
        ];
    }
}
