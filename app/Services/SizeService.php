<?php

namespace App\Services;

use App\Models\Cake;

class SizeService
{
    public function getSizes(): array
    {
        $formattedSizes = [];
        foreach (Cake::SIZES as $index => $name) {
            $formattedSizes[] = [
                'name' => $name,
                'products_count' => $this->countProductsBySize($index),
            ];
        }
        return $formattedSizes;
    }

    private function countProductsBySize($index): int
    {
        $sizeKeys = [
            '6inch',
            '7inch',
            '8inch',
            '9inch',
            '10inch'
        ];

        $sizeKey = $sizeKeys[$index];
        $count = 0;

        $cakes = Cake::where('visible', true)->get();

        foreach ($cakes as $cake) {
            $sizes = json_decode($cake->size, true);
            if (isset($sizes[$sizeKey]) && $sizes[$sizeKey]['enabled'] == '1') {
                $count++;
            }
        }

        return $count;
    }
}
