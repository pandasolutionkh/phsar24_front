<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $_rules = [
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required'
        ];
        $this->validate($request, $_rules);

        try{
            if(getMailTo()){
                Mail::to(getMailTo())->send(new ContactMail($data));
            }else{
                return redirect()->route('contact')
                         ->with('message','Please contact the administrator. it is problem with email setting.');       
            }
        }catch(\Swift_TransportException $e){
            dd($e, app('mailer'));
        }
        
        return redirect()->route('contact')
                         ->with('message','Your data has sent successfully to administrator');
    }

}
