<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BContactUs extends Model
{
    use HasFactory;
    protected $table = 'bakerycontactus';
    protected $fillable = ['bakery_id', 'name', 'email', 'phone', 'message', 'status', 'type'];
}
