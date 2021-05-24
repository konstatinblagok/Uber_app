<?php

namespace App\View\Components\Site;

use App\Models\MealMedia;
use Illuminate\View\Component;

class MealGallery extends Component
{
    public $medias;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mealId) {
        $this->medias = MealMedia::where('meal_id', $mealId)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('includes.site.components.meal-gallery');
    }
}
