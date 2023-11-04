<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Like extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'likes';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'user_id',
        'relation_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'relation_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'relation_id');
    }
}
