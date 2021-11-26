<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ContactMessageController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        if ($request->ajax()) {

            $data = ContactUs::select('*');

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
            
                                $btn = '<a href="' . route('admin.contact.message.view', $row->id) . '" class="edit btn btn-primary btn-sm">View</a>';
            
                                    return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }

        return view('admin.contactMessage.index');
    }

    public function view(Request $request, $id) {

        $contact = ContactUs::find($id);

        if(isset($contact) && $contact) {

            $data = [

                'contact' => $contact,
            ];
    
            return view('admin.contactMessage.detail', $data);
        }
        else {

            return redirect()->route('admin.contact.message.all')->with('error', 'No data found!');
        }
    }
}
