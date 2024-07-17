<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cake;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Products extends Component
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

    public $sortBy = 'latest';

    #[Computed()]
    public function cakes()
    {
        $query = Cake::where('visible', true)
            ->withFilters(
                $this->selected['prices'], 
                $this->selected['categories'], 
                $this->selected['flavours'], 
                $this->selected['bakeries'], 
                $this->selected['locations'], 
                $this->selected['sizes'], 
                $this->selected['preptimes'],
                $this->selected['averageRatings']
            );

        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->latest();
        }

        return $query->get();
    }

    protected $listeners = ['filterUpdated' => 'updateSelected'];

    #[On('update_selected')]
    public function updateSelected($selected, $type)
    {
        if ($type == 'price') {
            $this->selected['prices'] = $selected;
        }

        if ($type == 'category') {
            $this->selected['categories'] = $selected;
        }

        if ($type == 'flavour') {
            $this->selected['flavours'] = $selected;
        }

        if ($type == 'bakery') {
            $this->selected['bakeries'] = $selected;
        }

        if ($type == 'location') {
            $this->selected['locations'] = $selected;
        }

        if ($type == 'size') {
            $this->selected['sizes'] = $selected;
        }

        if ($type == 'preptime') {
            $this->selected['preptimes'] = $selected;
        }

        if ($type == 'averageRating') {
            $this->selected['averageRatings'] = $selected;
        }
    }

    #[On('sortUpdated')]
    public function updateSort($sortBy)
    {
        $this->sortBy = $sortBy;
    }

    public function applySort()
    {
        $this->dispatch('sortUpdated', $this->sortBy);
    }

    public function render()
    {
        return view('livewire.products');
    }
}
