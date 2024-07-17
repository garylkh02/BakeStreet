<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CakeCustomisation extends Model
{
    use HasFactory;
    protected $table = 'cake_customisations';
    protected $fillable = [
        'bakery_id', 'quantity', 'price', 'category_id', 'toppings_id',
        'flavours_id', 'deldate', 'deltime', 'message_on_cake',
        'message', 'bcandle', 'scandle', 'name', 'email', 'phone', 'billaddress','photo', 'size',
    ];

    public function bakery()
    {
        return $this->belongsTo(Bakery::class, 'bakery_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function toppings()
    {
        return $this->belongsTo(Topping::class, 'toppings_id');
    }

    public function flavours()
    {
        return $this->belongsTo(Flavour::class, 'flavours_id');
    }
    
}