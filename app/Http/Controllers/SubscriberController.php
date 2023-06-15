<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $subscriber_email = $request->subscriber_email;
        $subscriber = Subscriber::where('email', $subscriber_email)->first();
        if ($subscriber) {
            return ['message' => 'Already subscribed!', 'subscriber' => $subscriber, 'class' => 'text-warning'];
        }
        $subscriber = Subscriber::create([
            'email' => $subscriber_email,
            'subscribed_at' => now()
        ]);
        return ['message' => 'Thank you for subscribing', 'subscriber' => $subscriber, 'class' => 'text-success'];
    }
}
