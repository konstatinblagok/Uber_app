<?php

namespace App\Http\Controllers\Admin;

use App\Models\FoodType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MealTypeController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        if ($request->ajax()) {

            $data = FoodType::select('*');

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status_string', function($row) {

                                $type = '';

                                if($row->status == 1) {

                                    $type = '<span class="badge badge-success">Active</span>';
                                }
                                else {

                                    $type = '<span class="badge badge-danger">Inactive</span>';
                                }
            
                                return $type;
                            })
                            ->addColumn('action', function($row){

                                $btn = '';

                                if($row->status == 1) {

                                    $btn .= '<a href="' . route('admin.meal.type.status', $row->id) . '" class="edit btn btn-danger btn-sm">Inactive</a>';
                                }
                                else {

                                    $btn .= '<a href="' . route('admin.meal.type.status', $row->id) . '" class="edit btn btn-success btn-sm">Active</a>';
                                }

                                $btn .= '<a href="' . route('admin.meal.type.edit', $row->id) . '" class="edit btn btn-primary btn-sm">View & Edit</a>';
            
                                return $btn;
                            })
                            ->rawColumns(['action', 'status_string'])
                            ->make(true);
        }

        return view('admin.mealType.all');
    }

    public function create(Request $request) {

        return view('admin.mealType.create');
    }

    public function save(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'name' => 'bail|required|string|max:255|unique:food_types',
            'status' => 'bail|required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $type = new FoodType();

        $type->name = $request->name;
        $type->status = $request->status;

        $type->save();

        return redirect()->back()->with('success', 'Type added successfully!');
    }

    public function edit(Request $request, $id) {

        $type = FoodType::find($id);

        if(isset($type) && $type) {

            $data = [

                'type' => $type,
            ];

            return view('admin.mealType.edit', $data);
        }
        else {

            return redirect()->route('admin.meal.type.all')->with('error', 'No data found!');
        }
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            
            'name' => 'bail|required|string|max:255|unique:food_types,name,'.$id,
            'status' => 'bail|required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $type = FoodType::findOrFail($id);

        $type->name = $request->name;
        $type->status = $request->status;

        $type->save();

        return redirect()->back()->with('success', 'Type updated successfully!');
    }

    public function status(Request $request, $id) {

        $type = FoodType::findOrFail($id);

        $statusValue = 0;
        
        if($type->status == 1) {

            $statusValue = 0;
        }
        else {

            $statusValue = 1;
        }

        $type->status = $statusValue;

        $type->save();

        return redirect()->back()->with('success', 'Type status updated successfully!');  
    }

    public function nameValidation(Request $request) {

        $statusValue = false;

        if(isset($request->requestFrom) && $request->requestFrom == 'edit') {

            if(FoodType::where('id', '!=', $request->id)->where('name', $request->name)->exists()) {

                $statusValue = true;
            }
        }
        else {

            if(FoodType::where('name', $request->name)->exists()) {

                $statusValue = true;
            }
        }

        return response()->json(['success' => $statusValue]);
    }
}
