<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $users = User::all();
        foreach ($users as $user){
            $data = [
                'username' => $user->username,
                'email' => $user->email,
            ];
            Mail::to($user->email)->send(new SendMail($data));
        }
        return response()->json([
            'message' => 'SendMail Success!',
        ], 200);
    }
}
