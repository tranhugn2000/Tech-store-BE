<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function getLoginPage()
    {
        return view('auth.login');
    }
    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191', 'regex:/^([a-z0-9_-]+)(\.[a-z0-9_-]+)*@([a-z0-9_-]+\.)+[a-z]{2,6}$/ix'],
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt(array_merge($request->only('email', 'password'), ['role' => config('constant.role.admin')]))) 
        {
            return redirect()->route('dashboard.index');

        }else{

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        
        }
    }
    public function doLogout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();

            return redirect()->route('getLogin');
        }
    }
}
