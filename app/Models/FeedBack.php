<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedBack extends BaseModel
{
    use HasFactory;

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
