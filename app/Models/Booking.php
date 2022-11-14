<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "package_id",
        "booking_date",
        "booking_date_end",
        "hasCancelRequest",
        "status_id",
        "parent_id",
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'booking_date_end' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(Booking::class, 'parent_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function cancelRequest()
    {
        return $this->hasOne(CancelRequest::class);
    }
}