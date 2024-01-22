<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{

    public function subscribe(Request $request)
    {
        try {
            $subscriber_email = $request->subscriber_email;
            $subscriber = Subscriber::where('email', $subscriber_email)->first();
            if ($subscriber && $subscriber->token_verification == null) {
                return ['message' => 'Already subscribed!', 'subscriber' => $subscriber, 'class' => 'text-warning'];
            }

            $token = \Str::random(70);
            $url = \URL::to("/subscribers/verify/$token");

            $data = ['name'=>"Driss Boumlik", 'url' => $url, 'email' => $subscriber_email];
            Mail::send('emails.subscription', $data, static function ($message) use ($subscriber_email) {
                $message->to($subscriber_email, '')
                    ->bcc(env('MAIL_TO_ADDRESS'), 'DB')
                    ->subject('Testing Subscribing');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Driss Boumlik');
            });

            $subscriber = Subscriber::where('email', $subscriber_email)->update(['token_verification' => $token]);

            return response()->json(['message' => 'Check your inbox to confirm!', 'class' => 'tc-alert-ok tc-white', 'icon' => '<i class="fa fa-fw fa-circle-check tc-white"></i>'], 200);
        } catch (\Throwable $e) {
            throw $e;
            return response()->json(['message' => 'Something went wrong, Please try again!', 'class' => 'tc-yellow-0', 'icon' => '<i class="fa fa-fw fa-times-circle tc-yellow-0"></i>'], 400);
        }
    }

    public function update(Request $request, $uuid)
    {
        try {
            $subscriber = Subscriber::where('subscription_id', $uuid)->first();
            if ($subscriber) {
                $subscriber->update([
                    "first_name" => $request->first_name ?? $subscriber->first_name,
                    "last_name" => $request->last_name ?? $subscriber->last_name,
                ]);
            }
            return response()->json(['message' => 'Data updated successfully!', 'next_url' => \URL::to("/subscribers/$subscriber->subscription_id"), 'class' => 'tc-alert-ok', 'icon' => '<i class="fa fa-fw fa-circle-check tc-blue"></i>'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Something went wrong, Please try again!', 'class' => 'tc-red-light', 'icon' => '<i class="fa fa-fw fa-times-circle tc-red-light"></i>'], 400);
        }
    }
}
