<?php

namespace App\Services;
use App\Models\Cake;

class PreptimeService
{
    public function getPreptimes(): array
    {
        $formattedPreptimes = [];
        foreach (Cake::PREPTIMES as $index => $name) {
            $formattedPreptimes[] = [
                'name' => $name,
                'products_count' => $this->countProductsByPreptime($index),
            ];
        }
        return $formattedPreptimes;
    }

    private function countProductsByPreptime($index): int
    {
        switch ($index) {
            case 0:
                return Cake::where('visible', true)
                           ->where('preptime', '5hours')
                           ->count(); 
            case 1:
                return Cake::where('visible', true)
                           ->where('preptime', '1day')
                           ->count(); 
            case 2:
                return Cake::where('visible', true)
                           ->where('preptime', '2day')
                           ->count(); 
            case 3:
                return Cake::where('visible', true)
                           ->where('preptime', '3day')
                           ->count(); 
            default:
                return 0; 
        }
    }
}
