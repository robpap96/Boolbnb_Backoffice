<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = [];
        $user_id = Auth::user()->id;

        // get all apartments owned by logged user
        $my_apartments = Apartment::where('user_id', $user_id)->get();

        // Get all messages owned by a logged in user
        $data = Message::with('apartment')->get();

        foreach ($data as $message) {
            if( $message['apartment']['user_id'] === $user_id ) {
                $messages[] = $message;
            }
        }

        return view('admin.messages.index', compact('messages', 'my_apartments'));
    }

}