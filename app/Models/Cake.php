<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cake extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'addons', 'ingredients', 'allergens', 'description', 'items', 'cakecare', 'bakery_id', 'category_id', 'flavour_id', 'photo', 'occasions', 'preptime', 'selfcollect', 'size'];

    protected $casts = [
        'addons' => 'array',
        'size' => 'array'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function flavour()
    {
        return $this->belongsTo(Flavour::class);
    }

    public function bakery()
    {
        return $this->belongsTo(Bakery::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('product_title', 'price', 'quantity', 'bcandle', 'scandle', 'message', 'deldate', 'deltime', 'size', 'addons')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'cake_id', 'user_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    const PRICES = [
        'Less than 50',
        'From 50 to 100',
        'From 100 to 500',
        'More than 500',
    ];

    const SIZES = [
        '6inch',
        '7inch',
        '8inch',
        '9inch',
        '10inch',
    ];

    const PREPTIMES = [
        '5 Hours',
        '1 Day',
        '2 Days',
        '3 Days',
    ];

    const AVERAGERATINGS = [
        '1 and above',
        '2 and above',
        '3 and above',
        '4 and above',
        '5',
    ];    

    public function scopeWithFilters(Builder $query, $prices = [], $categories = [], $flavours = [], $bakeries = [], $locations = [], $sizes = [], $preptimes = [], $averageRatings = [])
    {
        return $query
            ->when(!empty($bakeries), fn($q) => $q->where('bakery_id', $bakeries))
            ->when(!empty($categories), fn($q) => $q->where('category_id', $categories))
            ->when(!empty($flavours), fn($q) => $q->where('flavour_id', $flavours))
            ->when(!empty($prices), fn($q) => $q->where(function($q) use ($prices) {
                $q->when(self::PRICES[0]  == $prices, fn($q) => $q->orWhere('price', '<', 50))
                ->when(self::PRICES[1]  == $prices, fn($q) => $q->orWhereBetween('price', [50, 100]))
                ->when(self::PRICES[2]  == $prices, fn($q) => $q->orWhereBetween('price', [100, 500]))
                ->when(self::PRICES[3]  == $prices, fn($q) => $q->orWhere('price', '>', 500));
            }))

            ->when(!empty($averageRatings), fn($q) => $q->whereHas('reviews', function($q) use ($averageRatings) {
                $q->when($averageRatings === self::AVERAGERATINGS[0], function($q) {
                    return $q->selectRaw('cake_id, AVG(rating) as avg_rating')
                            ->groupBy('cake_id')
                            ->havingRaw('AVG(rating) >= 1 AND AVG(rating) < 2');
                    })
                    ->when($averageRatings === self::AVERAGERATINGS[1], function($q) {
                        return $q->selectRaw('cake_id, AVG(rating) as avg_rating')
                                    ->groupBy('cake_id')
                                    ->havingRaw('AVG(rating) >= 2 AND AVG(rating) < 3');
                        })
                    
                    ->when($averageRatings === self::AVERAGERATINGS[2], function($q) {
                        return $q->selectRaw('cake_id, AVG(rating) as avg_rating')
                                    ->groupBy('cake_id')
                                    ->havingRaw('AVG(rating) >= 3 AND AVG(rating) < 4');
                        })

                    ->when($averageRatings === self::AVERAGERATINGS[3], function($q) {
                        return $q->selectRaw('cake_id, AVG(rating) as avg_rating')
                                    ->groupBy('cake_id')
                                    ->havingRaw('AVG(rating) >= 4 AND AVG(rating) < 5');
                        })

                    ->when($averageRatings === self::AVERAGERATINGS[4], function($q) {
                        return $q->selectRaw('cake_id, AVG(rating) as avg_rating')
                                    ->groupBy('cake_id')
                                    ->havingRaw('AVG(rating) = 5');
                        });    
            }))
        
            ->when(!empty($locations), fn($q) => $q->where('bakery_id', $locations))
            
            ->when(!empty($sizes), fn($q) => $q->where(function($q) use ($sizes) {
                $q->when(self::SIZES[0]  == $sizes, fn($q) => $q->orWhere('size', 'like','%6inch%'))
                ->when(self::SIZES[1]  == $sizes, fn($q) => $q->orWhere('size', 'like','%7inch%'))
                ->when(self::SIZES[2]  == $sizes, fn($q) => $q->orWhere('size', 'like','%8inch%'))
                ->when(self::SIZES[3]  == $sizes, fn($q) => $q->orWhere('size', 'like','%9inch%'))
                ->when(self::SIZES[4]  == $sizes, fn($q) => $q->orWhere('size', 'like','%10inch%'));
            }))

            ->when(!empty($preptimes), fn($q) => $q->where(function($q) use ($preptimes) {
                $q->when(self::PREPTIMES[0]  == $preptimes, fn($q) => $q->orWhere('preptime', '5hours'))
                ->when(self::PREPTIMES[1]  == $preptimes, fn($q) => $q->orWhere('preptime', '1day'))
                ->when(self::PREPTIMES[2]  == $preptimes, fn($q) => $q->orWhere('preptime', '2day'))
                ->when(self::PREPTIMES[3]  == $preptimes, fn($q) => $q->orWhere('preptime', '3day'));
            }));
    }

    

}
