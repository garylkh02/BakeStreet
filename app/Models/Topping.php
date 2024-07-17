<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function cakeCustomisations()
    {
        return $this->hasMany(CakeCustomisation::class);
    }
}
