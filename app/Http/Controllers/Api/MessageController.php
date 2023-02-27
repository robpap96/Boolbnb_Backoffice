<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create($email,$content)
    {
        $new_message = new Message();
        $new_message->email = $email;
        $new_message->content = $content;
        $new_message->apartment_id = 1;
        $new_message->save();

    }
}

