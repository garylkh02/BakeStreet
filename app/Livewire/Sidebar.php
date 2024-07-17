<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bakery;
use App\Models\Category;
use App\Models\Flavour;
use App\Services\PriceService;
use App\Services\SizeService;
use App\Services\averageRatingService;
use App\Services\PreptimeService;

class Sidebar extends Component
{
    public array $selected = [
        'prices' => [],
        'categories' => [],
        'flavours' => [],
        'bakeries' => [],
        'locations' => [],
        'sizes' => [],
        'preptimes' => [],
        'averageRatings' => [],
    ];
    
    public $selectedFilters = [];

    public function mount()
    {
        $this->selectedFilters = $this->selected;
    }

    public function updateFilters()
    {
        $this->dispatch('filterUpdated', $this->selectedFilters);
    }

    public function clearFilters()
    {
        return redirect()->to('/allproducts');
    }

    public function render(PriceService $priceService, SizeService $sizeService, PreptimeService $preptimeService, averageRatingService $averageRatingService)
    {
        $prices = $priceService->getPrices([], $this->selected['categories'], $this->selected['flavours'], $this->selected['bakeries'], $this->selected['locations'], $this->selected['sizes'], $this->selected['preptimes'], $this->selected['averageRatings']);
        $categories = Category::withCount(['cakes' => function($q) {
            $q->where('visible', true)
              ->withFilters($this->selected['prices'], [], $this->selected['flavours'], $this->selected['bakeries'], $this->selected['locations'], $this->selected['sizes'], $this->selected['preptimes'], $this->selected['averageRatings']);
        }])->get();
        $flavours = Flavour::withCount(['cakes' => function($q) {
            $q->where('visible', true)
              ->withFilters($this->selected['prices'], $this->selected['categories'], [], $this->selected['bakeries'], $this->selected['locations'], $this->selected['sizes'], $this->selected['preptimes'], $this->selected['averageRatings']);
        }])->get();
        $bakeries = Bakery::withCount(['cakes' => function($q) {
            $q->where('visible', true)
              ->withFilters($this->selected['prices'], $this->selected['categories'], $this->selected['flavours'], [], $this->selected['locations'], $this->selected['sizes'], $this->selected['preptimes'], $this->selected['averageRatings']);
        }])->get();
        $locations = Bakery::withCount(['cakes' => function($q) {
            $q->where('visible', true)
              ->withFilters($this->selected['prices'], $this->selected['categories'], $this->selected['flavours'], $this->selected['bakeries'], [], $this->selected['sizes'], $this->selected['preptimes'], $this->selected['averageRatings']);
        }])->get();
        $sizes = $sizeService->getSizes($this->selected['prices'], $this->selected['categories'], $this->selected['flavours'], $this->selected['bakeries'], $this->selected['locations'], [], $this->selected['preptimes'], $this->selected['averageRatings']);
        $preptimes = $preptimeService->getPreptimes($this->selected['prices'], $this->selected['categories'], $this->selected['flavours'], $this->selected['bakeries'], $this->selected['locations'], $this->selected['sizes'], [], $this->selected['averageRatings']);
        $averageRatings = $averageRatingService->getAverageRatings($this->selected['prices'], $this->selected['categories'], $this->selected['flavours'], $this->selected['bakeries'], $this->selected['locations'], $this->selected['sizes'], $this->selected['preptimes'], []);
        return view('livewire.sidebar', ['prices' => $prices, 'categories' => $categories, 'flavours' => $flavours, 'bakeries' => $bakeries, 'locations' => $locations, 'sizes' => $sizes, 'preptimes' => $preptimes, 'averageRatings' => $averageRatings]);
    }
}
