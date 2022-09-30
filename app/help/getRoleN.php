<?php
namespace app\help;

use Illuminate\Support\Facades\Auth;

class Help {
  public static function index(){
    Auth::user()->getRoleNames();
  }
}

