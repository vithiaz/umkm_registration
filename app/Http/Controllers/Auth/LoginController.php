<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 

    protected function credentials(Request $request)
    {
        return [
            'nip' => $request->nip,
            'birth' => $request->birth,
        ];
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
    
        return Auth::attempt($credentials, $request->filled('remember'));
    }

    public function username()
    {
        return 'nip';
    }





}
