<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserContact;
use Auth;
use Hash;

use Carbon\Carbon;
use App\Models\Setting;
use DB;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = getUserId();
        $user = User::find($id);

        if(empty($user)){
            return back()->with('message','This profile is not found');
        }

        return view('profile.index',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = getUserId();
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:users,phone,'.$id.',id,enabled,1',
            'email' => 'required|email|unique:users,email,'.$id.',id,enabled,1',
        ]);

        $input = $request->all();
        
        $data = User::find($id);
        $_db_photo = $data->photo;

        $data->update($input);

        if($input['photo_path']){
            $_photo = $input['photo'];
            $_src = "tmp/$_photo";
            $_dest = "profiles/$_photo";
            $_done = getDisk()->move($_src,$_dest);
            if($_done){
                if($_db_photo){
                    getDisk()->delete("profiles/$_db_photo");
                }
            }
        }

        return redirect()->route('profile.index')
                        ->with('message','Profile has updated successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $id = getUserId();
        $user = User::find($id);

        if(empty($user)){
            return back()->with('message','This profile is not found');
        }

        return view('profile.change_password',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $id = getUserId();
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required|string|min:6',
        ]);

        $input = $request->all();
        $data = User::find($id);

        if(empty($data)){
            return back()->with('warning','This profile is not found');
        }

        $current_password = $input['current_password'];
        if(!Hash::check($current_password, $data->password)){
            return back()->with('warning','Your current password is not correct!');
        }

        $new_password = Hash::make($input['new_password']);
        $data->update(['password'=>$new_password]);

        return redirect()->route('profile.change_password')
                        ->with('message','Password has changed successfully');
    }


    //contact
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {
        $id = getUserId();
        $user = User::where('id',$id)->where('enabled',true)->first();

        if(empty($user)){
            return back()->with('message','This profile is not found');
        }
        $userContact = UserContact::find($id);
        if(empty($userContact)){
            $userContact = new UserContact();
            $userContact->email = $user->email;
            $userContact->phone = $user->phone;
        }
        return view('profile.contact',compact('userContact'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createContact(Request $request)
    {
        $id = getUserId();
        $user = User::where('id',$id)->where('enabled',true)->first();
        if(empty($user)){
            return back()->with('message','This profile is not found');
        }

        $request['user_id'] = $id;
        $_messages = [
            'province_id.required' => 'The location field is required.'
        ];
        $this->validate($request, [
            'user_id' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:9',
            'address' => 'required',
            'province_id' => 'required',
        ],$_messages);

        $input = $request->all();
        $data = UserContact::find($id);

        if(empty($data)){
            UserContact::create($input);
        }else{
            $data->update($input);
        }

        return redirect()->route('profile.contact')
                        ->with('message','Contact has saved successfully');
    }

}
