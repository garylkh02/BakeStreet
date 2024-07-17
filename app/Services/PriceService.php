<?php

namespace App\Services;
use App\Models\Cake;

class PriceService
{
    public function getPrices(): array
    {
        $formattedPrices = [];
        foreach (Cake::PRICES as $index => $name) {
            $formattedPrices[] = [
                'name' => $name,
                'products_count' => $this->countProductsByPrice($index),
            ];
        }
        return $formattedPrices;
    }

    private function countProductsByPrice($index): int
    {
        switch ($index) {
            case 0:
                return Cake::where('visible', true)
                           ->where('price', '<', 50)
                           ->count(); 
            case 1:
                return Cake::where('visible', true)
                           ->whereBetween('price', [50, 100])
                           ->count(); 
            case 2:
                return Cake::where('visible', true)
                           ->whereBetween('price', [100, 500])
                           ->count(); 
            case 3:
                return Cake::where('visible', true)
                           ->where('price', '>', 500)
                           ->count(); 
            default:
                return 0; 
        }
    }
}

