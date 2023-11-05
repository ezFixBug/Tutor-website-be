<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class TeachSubject extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'teach_subjects';
    public $timestamps = true;

    public $fillable = [
        'id',
        'user_id',
        'subject_id',
        'class_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classes()
    {
        return $this->hasMany(TeachSubjectClasses::class);
    }
}
