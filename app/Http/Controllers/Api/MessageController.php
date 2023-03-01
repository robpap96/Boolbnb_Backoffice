<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create($name, $email, $content, $apartment_id)
    {
        $new_message = new Message();
        $new_message->name = $name;
        $new_message->email = $email;
        $new_message->content = $content;
        $new_message->apartment_id = $apartment_id;
        $new_message->save();
    }
}

