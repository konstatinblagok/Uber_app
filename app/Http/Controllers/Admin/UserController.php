<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Country;
use App\Models\FoodType;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Models\CookFoodSpeciality;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        if ($request->ajax()) {

            $data = User::with('currency')->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('user_phone', function(User $data){
                                
                                return $data->country_code.' '.$data->phone;
                            })
                            ->addColumn('balance', function(User $data){

                                $type = '';
                                
                                if($data->isCook()) {

                                    $type = $data->currency->symbol.' '.$data->remaining_amount;
                                }
                                else {

                                    $type = '---';
                                }

                                return $type;
                            })
                            ->addColumn('role', function(User $data){
                                
                                $type = '';
                                
                                if($data->isAdmin()) {

                                    $type = '<span class="badge badge-warning">Admin</span>';
                                }
                                else if($data->isCook()) {

                                    $type = '<span class="badge badge-info">Cook</span>';
                                }
                                else if($data->isCustomer()) {

                                    $type = '<span class="badge badge-success">Customer</span>';
                                }

                                return $type;
                            })
                            ->addColumn('email_verification', function(User $data){
                                
                                $type1 = '';
                                
                                if(isset($data->email_verified_at)) {

                                    $type1 = '<span class="badge badge-success">Yes</span>';
                                }
                                else {

                                    $type1 = '<span class="badge badge-danger">No</span>';
                                }

                                return $type1;
                            })
                            ->addColumn('user_status', function(User $data){
                                
                                $type = '';
                                
                                if($data->user_status_id == 1) {

                                    $type = '<span class="badge badge-info">Pending Approval</span>';
                                }
                                else if($data->user_status_id == 2) {

                                    $type = '<span class="badge badge-success">Approved</span>';
                                }
                                else if($data->user_status_id == 3) {
            
                                    $type = '<span class="badge badge-warning">Blocked</span>';
                                }
                                else if($data->user_status_id == 4) {

                                    $type = '<span class="badge badge-danger">Deleted</span>';
                                }

                                return $type;
                            })
                            ->addColumn('action', function(User $row){
            
                                $btn = '<a href="' . route('admin.user.edit', $row->id) . '" class="edit btn btn-primary btn-sm">View & Edit</a>';
                                
                                if($row->is_approved == 1) {

                                    $btn .= '<a href="' . route('admin.user.status', $row->id) . '" class="edit btn btn-warning btn-sm" >Unapprove</a>';
                                }
                                else {

                                    $btn .= '<a href="' . route('admin.user.status', $row->id) . '" class="edit btn btn-info btn-sm" >Approve</a>';
                                }
            
                                return $btn;
                            })
                            ->rawColumns(['role', 'user_status', 'action', 'email_verification'])
                            ->make(true);
        }

        return view('admin.user.all');
    }

    public function create(Request $request) {

        $roles = UserRole::all();
        $contries = Country::where('status', 1)->get();
        $foodType = FoodType::where('status', 1)->get();

        $data = [

            'roles' => $roles,
            'contries' => $contries,
            'foodType' => $foodType,
        ];

        return view('admin.user.create', $data);
    }

    public function save(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'userType' => 'bail|required',
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'countryCode' => 'required',
            'phone' => 'bail|required|min:6|max:15', Rule::unique('users')->where(function ($query) use($request) {
                return $query->where('country_code', $request->countryCode)
                ->where('phone', $request->phone);
            }),
            'password' => 'bail|required|string|min:6',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = new User();

        $user->user_role_id = $request->userType;
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->emailVerification == 'Yes') {

            $user->email_verified_at = date('Y-m-d H:i:s');
        }   

        $user->country_code = $request->countryCode;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        if(isset($request->status) && $request->status == 'approved') {

            $user->is_approved = 1;
            $user->approved_at = date('Y-m-d H:i:s');
            $user->user_status_id = 2;
        }
        else {

            $user->is_approved = 0;
            $user->approved_at = NULL;
            $user->user_status_id = 1;
        }

        $user->currency_id = 1;
        $user->save();

        if($user) {

            sendLoginInfoEmailByAdmin($user, $request->password);

            if($user->isCook()) {

                $data = array();
                $foodSpecialityString = '';

                foreach($request->foodType as $foodType) {

                    $data[] = ['user_id' => $user->id, 'food_type_id' => $foodType];

                    $foodSpecialityString .= FoodType::where('id', $foodType)->where('status', 1)->first() ? FoodType::where('id', $foodType)->where('status', 1)->first()->name.',' : '';
                }

                CookFoodSpeciality::insert($data);
            }

            return redirect()->back()->with('success', 'User created successfully!');
        }
        else {

            return redirect()->back()->with('error', 'Something went wrong!');
        } 
    }

    public function edit(Request $request, $id) {

        $user = User::find($id);

        if(isset($user) && $user) {

            $cookFoodType = CookFoodSpeciality::where('user_id', $id)->pluck('food_type_id')->toArray();
            $roles = UserRole::all();
            $contries = Country::where('status', 1)->get();
            $foodType = FoodType::where('status', 1)->get();

            $data = [

                'user' => $user,
                'cookFoodType' => $cookFoodType,
                'roles' => $roles,
                'contries' => $contries,
                'foodType' => $foodType,
            ];

            return view('admin.user.edit', $data);
        }
        else {

            return redirect()->back()->with('error', 'No User found!');
        }
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            
            'userType' => 'bail|required',
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users,email,'.$id,
            'countryCode' => 'required',
            'phone' => 'bail|required|min:6|max:15', Rule::unique('users')->where(function ($query) use($request, $id) {

                return $query->where('id', '!=', $id)->where('country_code', $request->countryCode)->where('phone', $request->phone);
            }),
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::findOrFail($id);

        $user->user_role_id = $request->userType;
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->emailVerification == 'Yes') {

            $user->email_verified_at = date('Y-m-d H:i:s');
        }
        else {

            $user->email_verified_at = NULL;
        }   

        $user->country_code = $request->countryCode;
        $user->phone = $request->phone;

        if(isset($request->password) && trim($request->password) != '') {

            $user->password = Hash::make($request->password);
        }

        if(isset($request->status) && $request->status == 'approved') {

            $user->is_approved = 1;
            $user->approved_at = date('Y-m-d H:i:s');
            $user->user_status_id = 2;
        }
        else {

            $user->is_approved = 0;
            $user->approved_at = NULL;
            $user->user_status_id = 1;
        }

        $user->currency_id = 1;
        $user->save();

        if($user) {

            if($user->isCook()) {

                CookFoodSpeciality::where('user_id', $user->id)->delete();

                $data = array();
                $foodSpecialityString = '';

                foreach($request->foodType as $foodType) {

                    $data[] = ['user_id' => $user->id, 'food_type_id' => $foodType];

                    $foodSpecialityString .= FoodType::where('id', $foodType)->where('status', 1)->first() ? FoodType::where('id', $foodType)->where('status', 1)->first()->name.',' : '';
                }

                CookFoodSpeciality::insert($data);
            }

            return redirect()->back()->with('success', 'User updated successfully!');
        }
        else {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function status(Request $request, $id) {

        $user = User::find($id);

        if(isset($user) && $user) {

            if($user->is_approved == 0) {

                $user->is_approved = 1;
                $user->user_status_id = 2;
            }
            else {

                $user->is_approved = 0;
                $user->user_status_id = 1;
            }

            $user->save();

            return redirect()->back()->with('success', 'User status updated successfully!');
        }
        else {

            return redirect()->back()->with('error', 'User not found!');
        }
    }
}
