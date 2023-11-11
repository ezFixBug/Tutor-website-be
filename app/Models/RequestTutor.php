<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class RequestTutor extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'request_tutors';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'title',
        'sub_title',
        'subject_id',
        'class_id',
        'type_cd',
        'course_type_cd',
        'num_day_per_week',
        'num_hour_per_day',
        'num_student',
        'price',
        'sex',
        'user_id',
        'description',
        'schedule',
        'schedule',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getScheduleAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function setScheduleAttribute($value)
    {
        $this->attributes['schedule'] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(UserClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function offers()
    {
        return $this->hasMany(OfferRequest::class, 'request_id');
    }
}
