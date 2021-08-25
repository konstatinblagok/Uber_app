<?php 

use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

function getMealAvailablePortion($mealID) {

    $availablePortion = 0;

    if(Meal::where(['id' => $mealID])->exists()) {

        $mealData = Meal::where(['id' => $mealID])->first();
        
        $availablePortion = $mealData->portions - $mealData->reserved_portions;
    }

    return $availablePortion;
}