<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showProfile(){
        
        return view('user.profile');
    }

    public static function updatePicture ($user, $picture_file){
        //        Save Picture
        $user->picture_url = Storage::url(
            $picture_file->storeAs(
                "/users/{$user->id}",
                "user_{$user->id}_img.{$picture_file->extension()}",
                'public'
            )
        );
        $user->save();
    }

//    public function updateProfile(Request $request){
//        $user = Auth::user();
//        $data = $request->all();
//
//        $request->validate([
//            'fst_name' => [ 'string', 'max:255'],
//            'lst_name' => [ 'string', 'max:255'],
//            'phone' => [ 'numeric', 'max:15'],
//            'address' => [ 'string', 'max:255'],
//            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        if($request->has('picture')){
//            UserController::updatePicture($user, $data['picture']);
//        }
//
//        $user->update($data);
//        return redirect()->back();
//
//    }
}
