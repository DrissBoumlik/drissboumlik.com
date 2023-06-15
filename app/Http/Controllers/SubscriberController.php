<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $subscriber_email = $request->subscriber_email;
        $subscriber = Subscriber::where('email', $subscriber_email)->first();
//        if ($subscriber) {
//            return ['message' => 'Already subscribed!', 'subscriber' => $subscriber, 'class' => 'text-warning'];
//        }

        try {
            $data = array('name'=>"Driss Boumlik");
            $x = Mail::send('mail', $data, static function ($message) use ($subscriber_email) {
                $message->to($subscriber_email, '')
                    ->subject('Testing Subscribing');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Driss Boumlik');
            });
            Mail::flushMacros();
            dd($x);
        } catch (\Throwable $th) {
            dd($th);
        }
        dd(11);

        $subscriber = Subscriber::create([
            'email' => $subscriber_email,
            'subscribed_at' => now()
        ]);
        return ['message' => 'Thank you for subscribing', 'subscriber' => $subscriber, 'class' => 'text-success'];
    }
}
