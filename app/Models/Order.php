<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'promocode',
        'discount',
        'newprice',
        'delmethod',
        'status',
        'recphone',
        'recipient_name',
        'street',
        'postcode',
        'city',
        'state',
        'first_order',
        'deliveryfee',
        'pricebefdis',
        'subtotal',
        'service_tax',
        'delivery_instructions'
    ];

    public function cakes()
    {
        return $this->belongsToMany(Cake::class, 'order_items')
                    ->withPivot('product_title', 'price', 'quantity', 'bcandle', 'scandle', 'message', 'deldate', 'deltime', 'size', 'addons')
                    ->withTimestamps();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
   
}
