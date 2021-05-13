<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\SGlobal;
use App\Services\User\SUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

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

     private $sGlobal;
     private $sUser;
     private $sFeature;

    public function __construct(SGlobal $sGlobal, SUser $sUser)
    {
        $this->middleware('guest')->except('logout');
        $this->sGlobal = $sGlobal;
        $this->sUser = $sUser;
    }

    public function viewLogin(){
        return $this->sGlobal->view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $data=array(
            'code'    => 400,
            'message' => '',
            'data'    => null,
        );

        $username = $request->username;
        $password = md5($request->password);


        $user = $this->sUser->login($username, $password);
        if(!$user['status'])
        {
            return redirect('/')->with('error', 'Invalid username or password');
        }

        if($request->session()->has('id')) $request->session()->forget('id');
        if($request->session()->has('user_name')) $request->session()->forget('user_name');
        if($request->session()->has('role_id')) $request->session()->forget('role_id');
        // if($request->session()->has('main_menu')) $request->session()->forget('main_menu');

        $request->session()->put('id', $user['data']['id']);
        $request->session()->put('user_name', $user['data']['name']);
        $request->session()->put('role_id', $user['data']['role_id']);
        // $request->session()->put('main_menu', $main_menu);

        $data['status'] = true;
        $data['message'] = 'Login Success';
        $data['data'] = $user['data'];

        // $link = $this->sglobal->getActiveLink();
        return redirect('/home');
    }

    public function doLogout()
    {
        // Auth::logout();
        Session::forget('message');
        Session::forget('errors');
        Session::forget('success');

        Session::forget('id');
        Session::forget('name');
        Session::forget('role_id');

        return redirect('/');
    }
}
