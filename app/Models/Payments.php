<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerCourse()
    {
        return $this->belongsTo(RegisterCourse::class);
    }

    public function registerOffer()
    {
        return $this->belongsTo(OfferRequest::class, 'offer_request_id');
    }
}
