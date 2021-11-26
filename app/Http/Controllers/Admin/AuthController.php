<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct() {

        $this->middleware('guest');
    }
    
    public function loginPage(Request $request) {

        return view('admin.auth.login');
    }
}
