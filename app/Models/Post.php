<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Post extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'posts';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'title',
        'user_id',
        'image',
        'type_cd',
        'description',
        'content',
        'view',
        'like',
        'tags',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTagsAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
