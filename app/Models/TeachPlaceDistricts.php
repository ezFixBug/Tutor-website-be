<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kjmtrue\VietnamZone\Models\District;

class TeachPlaceDistricts extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
