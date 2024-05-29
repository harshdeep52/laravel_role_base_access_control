<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("login/Login");
});

Route::get("login", [LoginController::class, "index"])->name('login');
Route::post("login", [LoginController::class, "login"]);
Route::get("logout", [LoginController::class, "logout"]);

Route::group(['prefix'=>'admin','middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get("/dashboard", [UserController::class, "dashboard"]);
    Route::get("/addUser", [UserController::class, "index"]);
    Route::post("/addNewUser", [UserController::class, "addUser"]);
    Route::get("/usersList", [UserController::class, "usersList"]);
    Route::get("/getUsersDetails", [UserController::class, "getUsersDetails"]);
    Route::post("/udpateUser", [UserController::class, "udpateUser"]);
    Route::post("/deteleUser", [UserController::class, "deteleUser"]);
});

Route::group(['prefix'=>'user', 'middleware' => ['isUser', 'auth', 'PreventBackHistory']], function () {
    Route::get("/userDashboard", [UserController::class, "userDashboard"])->name("userDashboard");
});
