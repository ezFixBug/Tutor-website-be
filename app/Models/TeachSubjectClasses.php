<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeachSubjectClasses extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function class()
    {
        return $this->belongsTo(UserClass::class, 'class_id');
    }
}
