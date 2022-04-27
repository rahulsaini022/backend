<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getStats(Request $request)
    {
       
            $users = User::count();
            $products = Product::count();
            $tests = User::role('test')->count();
            $all=array(
                'users' => $users,
                'products' => $products,
                'tests' => $tests,
                
            );
            echo json_encode($all);
      
    }
}
