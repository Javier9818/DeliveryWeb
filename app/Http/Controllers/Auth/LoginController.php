<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt(["email" => $request->username, "password" => $request->password]) || Auth::attempt(["username" => $request->username, "password" => $request->password])) {
            // Authentication passed...
            $user = DB::select('select id, isAdmin, isCustomer from users where username = ? or email = ?', [$request->username, $request->username]);
            if($user[0]->isAdmin){
               return redirect(route('admin-total-inicio'));}
            else if($user[0]->isCustomer){
                $empresa = DB::select('select * from users_empresas where user_id = ?', [$user[0]->id]);
                session(['empresa' => $empresa[0]->empresa_id]);
                // Session::put('empresa', $empresa[0]->empresa_id);
                return redirect()->intended('/intranet');
            }
            else
            {
                if(Session::has('url'))
                    if (session('url')=='/micarrito'){
                        session(['url'=>0]);
                        return  redirect('/micarrito');
                    }

                return redirect()->intended();
            }



        }else
            return redirect('/login')->with('message','Error logging in!');

    }
}
