<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Subject extends Model
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'subjects';
    public $timestamps = true;

    public $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'teach_subjects' , 'subject_id', 'user_id');
    }

    public function classes() 
    {
        return $this->belongsToMany(UserClass::class, 'teach_subjects', 'subject_id', 'class_id');
    }

    public function courses() 
    {
        return $this->belongsToMany(Course::class, 'course_subjects', 'subject_id', 'course_id');
    }
}
