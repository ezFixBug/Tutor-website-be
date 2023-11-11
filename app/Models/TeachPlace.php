<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kjmtrue\VietnamZone\Models\Province;

class TeachPlace extends BaseModel
{
    use HasFactory, Notifiable, SoftDeletes; 
    
    protected $table = 'teach_places';
    public $timestamps = true;

    public $fillable = [
        'id',
        'user_id',
        'province_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function teachPlaceDistricts()
    {
        return $this->hasMany(TeachPlaceDistricts::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
