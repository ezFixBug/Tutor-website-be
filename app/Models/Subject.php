<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Subject extends Model
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'subjects';
    public $timestamps = true;

    public $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
