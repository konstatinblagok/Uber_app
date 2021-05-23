<?php

namespace App\View\Components\Site;

use App\Models\Food;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\View\Component;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use function PHPUnit\Framework\throwException;

class MenuContent extends Component
{
    public $show_filters;
    public $meals;
    public $food_types;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showFilters = true, $recordsLimit = 29) {
        try{
            $this->show_filters = $showFilters;
            $filters = request();

            $pickup_time = Carbon::parse($filters->has('time') ?$filters->time : '05:30 PM')
                ->addMinutes(30)
                ->toTimeString();

            $this->food_types = Food::all();

            $meals = Meal::whereDate('pickup_time', '>=',  now())->whereTime('pickup_time', '<=', $pickup_time);

            if($filters->has('type') && $filters->type != 'all'){
                $meals->whereIn('todays_food', (array) $filters->type);
            }

            $this->meals = $meals->orderBy('pickup_time', 'desc')->paginate($recordsLimit);
        } catch (\Exception $exception){
            throw new BadRequestException();
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('includes.site.components.menu-content');
    }
}
