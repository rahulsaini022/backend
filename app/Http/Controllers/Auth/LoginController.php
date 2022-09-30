<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    // protected $maxAttempts = 5;
    // protected $decayMinutes = ;
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /** 
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
  // following function checks if user is active then login user
  protected function credentials(Request $request)
  {
      
      return [ 'email' => $request->email, 'password' => $request->password, 'status' => '1'];
      // return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => '1'];
  }
  protected function validateLogin(Request $request)
  {
      $request->validate([
          $this->username() => 'required|string',
          'password' => 'required|string',
      ]);
  }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('Admin')) {
            // return redirect('/admin');
            return redirect()->route('home', $user->getRoleNames()[0]);
        } else {
            // return redirect('/');
            return redirect()->intended('/');
        }
       
    }
}
