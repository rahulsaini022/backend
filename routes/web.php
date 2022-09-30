<?php

use app\help\Help;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
    if(Auth::check()){
        return redirect(Auth::user()->getRoleNames()[0].'/home');
    }
    else{
    return view('auth.login');
    }
});

Auth::routes();


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
// Route::group(['middleware' => ['auth', 'status', 'verified', 'twofactor']], function () {
     Route::group(['prefix'=> '{user_role}','middleware' => ['auth','status']], function() {
        
        
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('/get-stats', [AdminController::class, 'getStats'])->name('get.stats');
    Route::resource('roles', RoleController::class);
    Route::post('/status', [UserController::class, 'status'])->name('status');
    Route::resource('users', UserController::class);
    // Route::post('/new',[ UserController::class,'new']);
    Route::resource('products', ProductController::class);
});
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    auth()->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


