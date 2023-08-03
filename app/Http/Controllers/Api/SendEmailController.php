<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $description = $request->input('description');

        $myEmail = 'hung.btec20@gmail.com';

        Mail::to($myEmail)->send(new SendEmailPortfolio($name, $email, $description));

        return response()->json([
            'status'  => 0,
            'message' => "Gửi email thành công!",
        ], 200);
    }
}
