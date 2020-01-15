<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Cache;
use Auth;
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

    public function redirectTo()
    {
        return getLang();
    }

    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        // $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
        //     ? $this->username()
        //     : 'username';
        $field = $this->username();

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
            'enabled' => true,
            'is_activated' => true,
        ];
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
        $_ses_id = Session::getId();
        if (!($user->is_activated && $user->enabled)) {
            auth()->logout();
            $_msg = _t('Your account is invalid.').' '._t('Please contact administrator.');
            return back()->with('warning', $_msg);
        }

        $previous_session = $user->last_session;
        if ($previous_session) {
            $_ses = Session::getHandler()->read($previous_session);
            if($_ses != ''){
                $_data = unserialize($_ses);
                $_is_login = false;
                foreach ($_data as $key => $value) {
                    $_pos = strpos($key, 'login_web_');
                    if($_pos > -1){
                        $_is_login = true;
                        break;
                    }
                }

                if($_is_login && $user->isOnline()){
                    auth()->logout();
                    $_msg = _t('Your account is accessed by anyone.').' '._t('Please contact administrator.');
                    return back()->with('warning', $_msg);
                }
            }
        }

        $user->update(['last_session'=>$_ses_id]);

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        if(Auth::check()){
            Cache::forget('user-is-online-'.Auth::user()->id);
            $this->guard()->logout();
        }
        return redirect()->route('home',getLang());
    }
}
