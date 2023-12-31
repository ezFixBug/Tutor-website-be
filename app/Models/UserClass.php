<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserClass extends Model
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'classes';
    public $timestamps = true;

    public $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function subjects() 
    {
        return $this->belongsToMany(Subject::class, 'teach_subjects', 'class_id', 'subject_id');
    }

    public function courses() 
    {
        return $this->belongsToMany(Course::class, 'course_classes', 'class_id', 'course_id');
    }
}
