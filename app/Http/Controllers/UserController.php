<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];
        
        $attributes = [
            'email'    => 'Email',
            'password' => 'Password',
        ];
        
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('popup_code', 2);
        }

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('products.index')->with('success', 'login success');
        }

        return redirect()->route('login')->with('error', 'login failed');
    }

    public function createUser(Request $request)
    {
        $rules = [
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'first_name' => ['required', 'max:30'],
            'last_name' => ['required', 'max:30'],
            'password' => ['required', 'min:6'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->password,
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // flashMessage('success', Lang::get('messages.success'), Lang::get('messages.user_register_successful'));
            return redirect()->route('products.index');
        }

        // flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.login_failed'));
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        $redirect_url = route('login');
        return redirect($redirect_url);
    }
}
