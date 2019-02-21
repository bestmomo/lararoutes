<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\Contact;
use App\User;

class ContactController extends Controller
{
    /**
     * Send email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|max:500'
        ]);

        User::whereAdmin(true)->firstOrFail()->notify(new Contact($request->email, $request->message));

        return response()->json();
    }
}
