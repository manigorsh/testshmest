<?php

namespace App\Http\Controllers;

use App\ChatMessage;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$messages = DB::table('chat_messages')
			->join('users', 'chat_messages.user_id', '=', 'users.id')
            ->select('chat_messages.id', 'chat_messages.text', 'users.name')
            ->orderBy('chat_messages.id', 'desc')
            ->take(20)
            ->get();
            
        return $messages;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new ChatMessage();
        $message->user_id = Auth::user()->id;
        $message->text = htmlspecialchars($request->input('message'), ENT_QUOTES);
		$message->save();
        
        return $message;
    }

}
