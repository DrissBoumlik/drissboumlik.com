<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function show(Request $request, $uuid)
    {
        $data = pageSetup('Subscription | Update Data', 'update subscription data', true, true);
        $subscriber = Subscriber::where('subscription_id', $uuid)->first();
        return view('pages.subscription.verify', ['data' => $data, 'subscriber' => $subscriber]);
    }

    public function verifySubscribtion(Request $request, $token)
    {
        $data = pageSetup('Subscription | Update Data', 'subscription verification', true, true);
        $subscriber = Subscriber::where('token_verification', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                "subscribed_at" => now(),
                "token_verification" => null,
                "subscription_id" => \Str::uuid(),
            ]);
        }
        return view('pages.subscription.verify', ['data' => $data, 'subscriber' => $subscriber]);
    }

}
