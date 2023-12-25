<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class OfferRequest extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'offer_requests';
    public $timestamps = true;
    
    protected $casts = [
        'id' => 'string',
    ];

    public $fillable = [
        'id',
        'user_id',
        'request_id',
        'status_cd',
        'status_student_cd',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function request()
    {
        return $this->belongsTo(RequestTutor::class);
    }
}
