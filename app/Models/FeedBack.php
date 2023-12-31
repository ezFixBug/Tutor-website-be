<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedBack extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedbacks';
    public $timestamps = true;

    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'name',
        'email',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
