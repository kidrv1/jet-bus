<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'payment_receipt'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, "book_id");
    }
}