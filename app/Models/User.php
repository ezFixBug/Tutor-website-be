<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes; 

    protected $table = 'users';
    public $timestamps = true;

    public $fillable = [
        'id',
        'first_name',
        'last_name',
        'avatar',
        'user_name',
        'password',
        'email',
        'role_cd',
        'phone_number',
        'remember_token',
        'password_reset_token_period',
        'province_id',
        'district_id',
        'street',
        'birthday',
        'sex',
        'education',
        'job_current_id',
        'certificate',
        'front_citizen_card',
        'back_citizen_card',
        'title',
        'description',
        'cost',
        'type_cd',
        'active',
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
