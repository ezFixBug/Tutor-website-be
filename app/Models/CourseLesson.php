<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLesson extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
}
