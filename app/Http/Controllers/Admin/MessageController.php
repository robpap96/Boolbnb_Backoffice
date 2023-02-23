<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Get all apartments owned by a logged in user
        $messages = Message::with('apartment')->get();
        $user_id = Auth::user()->id;

        return view('admin.messages.index', compact('messages', 'user_id'));
    }

}