<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\File;

class MediaController extends Controller
{
    public function addFoodMedia($meal_id = null, Request $request) {
        if(!$request->file || !$meal_id || !Meal::find($meal_id)->exists()){
            return response()->json('error', 400);
        }

        $userId = Auth::id();
        $file = $request->file('file');

         $meal_media = new MealMedia([
            'name' => $file->getClientOriginalName(),
            'path' => Storage::url(
                    $file->storeAs(
                    "/users/{$userId}",
                    "user_{$userId}_img_".sha1(time()).".{$file->extension()}",
                    'public'
                )
            ),
            'size' => $file->getSize(),
            'details' => '',
            'meal_id' => $meal_id,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $status =$meal_media->save();
        if($status){
            return response()->json([ 'message' => 'Success', 'media_id' => $meal_media->id], 200);
        } else{
            return response()->json('Error', 400);
        }
    }

    public static function removeFoodMedia(Request $request) {
        $request->validate(['id' => 'required']);
        $meal_media = MealMedia::findOrFail($request->id);
        $status = $meal_media->delete();

        if($status){
            Storage::disk('public')
                ->delete(str_replace('/storage/', '', $meal_media->path)
            );
            return response()->json('Success', 200);
        } else{
            return response()->json('Error', 400);
        }
    }
}
