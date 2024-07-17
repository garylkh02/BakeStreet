<?php

namespace App\Services;

use App\Models\Cake;

class averageRatingService
{
    public function getAverageRatings(): array
    {
        $formattedRatings = [];
        foreach (Cake::AVERAGERATINGS as $index => $name) {
            $formattedRatings[] = [
                'name' => $name,
                'products_count' => $this->countProductsByRating($index),
            ];
        }
        return $formattedRatings;
    }

    private function countProductsByRating($index): int
    {
        switch ($index) {
            case 0:
                return Cake::where('visible', true)
                    ->whereHas('reviews', function($query) {
                        $query->havingRaw('AVG(rating) >= ?', [1])
                              ->havingRaw('AVG(rating) < ?', [2]);
                    })
                    ->count();
            case 1:
                return Cake::where('visible', true)
                    ->whereHas('reviews', function($query) {
                        $query->havingRaw('AVG(rating) >= ?', [2])
                              ->havingRaw('AVG(rating) < ?', [3]);
                    })
                    ->count();
            case 2:
                return Cake::where('visible', true)
                    ->whereHas('reviews', function($query) {
                        $query->havingRaw('AVG(rating) >= ?', [3])
                              ->havingRaw('AVG(rating) < ?', [4]);
                    })
                    ->count();
            case 3:
                return Cake::where('visible', true)
                    ->whereHas('reviews', function($query) {
                        $query->havingRaw('AVG(rating) >= ?', [4])
                              ->havingRaw('AVG(rating) < ?', [5]);
                    })
                    ->count();
            case 4:
                return Cake::where('visible', true)
                    ->whereHas('reviews', function($query) {
                        $query->havingRaw('AVG(rating) = ?', [5]);
                    })
                    ->count();
            default:
                return 0;
        }
    }
}
