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
use App\Models\Message;
use Carbon\Carbon;
use DB;
use App\Events\NewMessage;

class MessageController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('messages.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacts(Request $request)
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from_id` as sender_id, count(`from_id`) as messages_count'))
            ->where('to_id', auth()->id())
            ->where('read', false)
            ->groupBy('from_id')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);   
    }

    public function getMessagesFor($locat,$id)
    {
        // mark all messages with the selected contact as read
        Message::where('from_id', $id)->where('to_id', auth()->id())->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $current_id = getUserId();
        
        $messages = Message::where(function($q) use ($current_id, $id) {
            $q->where('from_id', $current_id);
            $q->where('to_id', $id);
        })->orWhere(function($q) use ($current_id, $id) {
            $q->where('from_id', $id);
            $q->where('to_id',$current_id);
        })
        ->orderBy('created_at','ASC')
        ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from_id' => auth()->id(),
            'to_id' => $request->contact_id,
            'message' => $request->text
        ]);

        $message = Message::find($message->id);

        event(new NewMessage($message));

        return response()->json($message);
    }
  
}

