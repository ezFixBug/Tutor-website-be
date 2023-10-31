<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class CourseSubject extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'course_subjects';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'course_id',
        'subject_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
