<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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


    /*
    Para trabajar con nuestras propias variables de login debemos implementar los metodos
    En Auth/LoginController public function username() retornando el campo usuario de nuestra tabla
    En Models/User public function getAuthPassword() retornando el campo contraseña de nuestra tabla
    tambien en la vista de login.blade.php solo cambiar el nombre y valores de email a nuestro usuario
     */

    use AuthenticatesUsers;

    public function username()
    {
        return 'us_usuario';
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo =RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
