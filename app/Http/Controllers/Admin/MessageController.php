<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        // Get all apartments owned by a logged in user
        $messages = Message::all();

        return view('admin.messages.index', compact('messages'));
    }

}
