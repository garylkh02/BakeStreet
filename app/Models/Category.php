<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function cakes(): HasMany
    {
        return $this->hasMany(Cake::class);
    }

    public function cakeCustomisations()
    {
        return $this->hasMany(CakeCustomisation::class);
    }
}
