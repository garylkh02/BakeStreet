<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'user_id',
        'expiry_date',
        'type',
        'is_used',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Coupon.php (Model)
    public function isExpired()
    {
        return $this->expiry_date < now();
    }

    public function isUsed()
    {
        return $this->used;
    }

}
