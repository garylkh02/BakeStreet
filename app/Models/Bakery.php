<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bakery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'user_id'];

    public function cakes(): HasMany
    {
        return $this->hasMany(Cake::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Cake::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Cake::class);
    }

    public function cakeCustomisations()
    {
        return $this->hasMany(CakeCustomisation::class);
    }
}
