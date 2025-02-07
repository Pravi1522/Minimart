<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use Auth;

class AdminController extends Controller
{
   
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $admin = Admin::where('email', $request->email)->first();
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }

    public function dashboard(){
        $data['user_count'] = User::count();
        $data['product_count'] = Product::count();
        $data['order_count'] = Order::count();
        return view('admin.dashboard', compact('data'));
    }
}
