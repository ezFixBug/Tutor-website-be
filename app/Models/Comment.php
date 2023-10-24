<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Comment extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'comments';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'content',
        'user_id',
        'relation_id',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function childrenComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
