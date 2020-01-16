<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserActivate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectTo()
    {
        return getLang();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'phone' => 'required|max:255|unique:users,phone,null,id,enabled,1',
            'email' => 'required|max:255|email|unique:users,email,null,id,enabled,1',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Customer
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $userActivate = UserActivate::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
        try{
            Mail::to($user->email)->send(new VerifyMail($user));
        }catch(\Swift_TransportException $e){
            //dd($e->getMessage());
        }
        
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        $translator = app('translator');
        $_msg = __('Please check your email, we have sent link to activate on your email.');
        return redirect()->route('login',getLang())->with('success', $_msg);
    }

    public function verifyUser($locale,$token)
    {
        $userActivate = UserActivate::where('token', $token)->first();
        $status = 'success';
        if(!empty($userActivate) ){
            $user = $userActivate->user;
            if(!$user->is_activated) {
                $userActivate->user->is_activated = 1;
                $userActivate->user->save();
                $msg = __("Your e-mail is verified. You can now login.");
            }else{
                $msg = __("Your e-mail is already verified. You can now login.");
            }
        }else{
            $status = 'warning';
            $msg = __("Sorry your email cannot be identified.");
        }
 
        return redirect()->route('login',getLang())->with($status, $msg);
    }
}
