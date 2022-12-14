<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'booking_date_end',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'booking_date_end' => 'datetime'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addons()
    {
        return $this->hasMany(CartAddon::class, "cart_id");
    }
}