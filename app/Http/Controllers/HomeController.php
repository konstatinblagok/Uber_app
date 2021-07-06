<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Menu;
use App\Models\ContactUs;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    public function showHomePage(){
        
        try {

            return view('index');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }        
    }

    public function showAboutUsPage() {

        try {

            return view('frontend.about-us');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        } 
    }

    public function showOurVisionPage() {

        try {

            return view('frontend.our-vision');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showHowItWorkPage() {

        try {

            return view('frontend.how-it-works');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showContactUsPage() {

        try {

            return view('frontend.contact-us');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function storeContactUs(Request $request) {

        try {

            $contact = new ContactUs();

            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;

            $contact->save();

            session()->flash("success", "Thanks for contacting us!");

            return redirect()->back();
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showMenuPage() {

        try {

            $menu = MenuCategory::with(['menu' => function($q1) {

                return $q1->with('currency')->where('status', true);
            }])->where('status', true)->get();

            $data = [

                'menu' => $menu,
            ];
            
            return view('frontend.menu', $data);
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
