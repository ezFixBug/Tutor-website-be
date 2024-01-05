<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'relation_id', 'id');
    }

    public function reportCourse()
    {
        return $this->belongsTo(Course::class, 'relation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
