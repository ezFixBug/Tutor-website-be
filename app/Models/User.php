<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kjmtrue\VietnamZone\Models\District;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Kjmtrue\VietnamZone\Models\Province;

class User extends BaseModel implements
    JWTSubject,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasFactory, Notifiable, SoftDeletes, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    protected $table = 'users';
    public $timestamps = true;

    protected $casts = [
        'id' => 'string',
    ];

    protected $appends = ['full_name'];

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
        'price',
        'type_cd',
        'status_cd',
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teach_subjects', 'user_id', 'subject_id');
    }

    public function teachSubjects()
    {
        return $this->hasMany(TeachSubject::class);
    }

    public function provinces()
    {
        return $this->belongsToMany(Province::class, 'teach_places', 'user_id', 'province_id');
    }

    public function teachPlaces()
    {
        return $this->hasMany(TeachPlace::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasOne(Like::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_current_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function rating()
    {
        return $this->hasMany(RatingTutor::class, 'tutor_id');
    }

    public function reported()
    {
        return  $this->hasMany(Report::class, 'relation_id');
    }

    public function revenue()
    {
        return $this->hasMany(Revenue::class);
    }
}