<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    function index()
    {
        return view("login/Login");
    }

    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()]);
        }
        if (Auth::attempt($request->only(["email", "password"]))) {
            $user = Auth::user();
            $loginResult = $user->toArray();

            $request->session()->put('id', $loginResult['id']);
            $request->session()->put('name', $loginResult['name']);
            $request->session()->put('mobile', $loginResult['mobile']);
            $request->session()->put('address', $loginResult['address']);
            $request->session()->put('user_role', $loginResult['user_roles']);
            if($loginResult['user_roles']  == 'admin'){
                $url ='/admin/dashboard';
            }elseif( $loginResult['user_roles']  == "user"){
                $url = '/user/userDashboard';
            }
            return response()->json([
                "status" => true,
                "redirect" => url($url),
                "message"  => "Login Success Please Wait..."
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => " Invalid credentials "
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('user_id');
        session()->flush();
        return redirect('/');
    }
}
