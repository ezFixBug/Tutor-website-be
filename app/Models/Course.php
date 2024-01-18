<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Course extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'courses';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'title',
        'sub_title',
        'user_id',
        'image',
        'type_cd',
        'price',
        'description',
        'content',
        'province_id',
        'district_id',
        'street',
        'link',
        'schedule',
        'start_date',
        'time_start',
        'tags',
        'view',
        'like',
        'status_cd',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTagsAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

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

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subjects', 'course_id', 'subject_id');
    }

    public function classes()
    {
        return $this->belongsToMany(UserClass::class, 'course_classes', 'course_id', 'class_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'relation_id');
    }

    public function rating()
    {
        return $this->hasMany(RatingCourse::class);
    }

    public function reported()
    {
        return  $this->hasMany(Report::class, 'relation_id');
    }
    public function lessons()
    {
        return $this->hasMany(CourseLesson::class);
    }
}
