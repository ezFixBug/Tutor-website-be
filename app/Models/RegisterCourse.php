<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class RegisterCourse extends baseModel
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'register_courses';
    public $timestamps = true;

    public $fillable = [
        'id',
        'user_id',
        'course_id',
        'status_cd',
        'approve_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course() 
    {
        return $this->belongsTo(Course::class);
    }
}
