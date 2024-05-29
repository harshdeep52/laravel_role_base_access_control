<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Datatable;


class UserController extends Controller
{
    function index()
    {
        return view("dashboard/addUser");
    }

    function dashboard(Request $request)
    {
       
        return view("dashboard/dashboard",["users"=>Auth::user()]);
    }

    function userDashboard(){
        return view("dashboard/userDashboard",["users"=>Auth::user()]);
    }

    function usersList()
    {
        if (request()->ajax()) {
            return datatables()->of(User::select('id', 'name', 'email', 'mobile', 'address', 'user_roles', 'user_status', 'created_at'))
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i'); // format date time
                })
                ->addColumn('action', function ($row) {
                    if ($row->user_status == "1") {
                        $btn = "<button disabled class='btn btn-link btn-sm'><i class='fa fa-edit' style='color:#1572e8;'></i></button>
                                <button disabled class='btn btn-link btn-sm'><i class='fa fa-times' style='color:#f25961;'></i></button>";
                    } else {
                        $btn = "<button onClick='editUser({$row->id})' class='btn btn-link btn-sm'><i class='fa fa-edit' style='color:#1572e8;'></i></button>
                                <button onClick='deleteUser({$row->id})' class='btn btn-link btn-sm'><i class='fa fa-times' style='color:#f25961;'></i></button>";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view("dashboard/usersList");
    }

    function addUser(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:users|max:50',
            'mobile'    => 'required|unique:users|numeric|digits:10',
            'user_role' => 'required',
            'address'   => 'required|max:200'
        ]);
        if (($validator->fails())) {
            return redirect('/admin/addUser')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = new User;
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->password      = Hash::make($request->password);
            $user->mobile        = $request->mobile;
            $user->user_roles    = $request->user_role;
            $user->user_status   = 0;
            $user->address       = $request->address;

            if ($user->save()) {
                return redirect('/admin/addUser')->with('message', 'new user added successfully');
            } else {
                return redirect('/admin/addUser')->with('message', 'error while adding user');
            }
        }
    }

    function getUsersDetails(Request $request)
    {
        $user = User::where('id', $request->id)->get();
        if (!empty($user)) {
            return response()->json([
                "status" => true,
                "data" => $user
            ]);
        } else {
            return response()->json([
                "status" => false,
                "data" => $user
            ]);
        }
    }

    function udpateUser(Request $request)
    {
        $id = $request->id;
        $user = User::where('id', $request->id)->first();
        unset($request['id']);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->user_roles = $request->user_role;

        $res = $user->save();

        if ($res) {
            return response()->json([
                "status" => true,
                "message" => "user updated successfully"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "error while updating user"
            ]);
        }
    }

    function deteleUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->user_status = 1;
        $res = $user->save();
        if($res){
            return response()->json([
                "status" => true,
                "message" => "user deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "error while deleted user"
            ]);
        }
    }
}
