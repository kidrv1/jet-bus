<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAddon extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'package_addon_id',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function addonRef()
    {
        return $this->belongsTo(PackageAddon::class, "package_addon_id");
    }
}