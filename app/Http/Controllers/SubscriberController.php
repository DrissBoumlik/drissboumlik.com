<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function update(Request $request, $email)
    {
        $data = new \stdClass;
        $data->title = "Subscription | Update Data";
        try {
            $subscriber = Subscriber::where('email', $email)->first();
            if ($subscriber) {
                $subscriber->update([
                    "first_name" => $request->first_name ?? $subscriber->first_name,
                    "last_name" => $request->last_name ?? $subscriber->last_name,
                ]);
            }
            $request->session()->flash('response', ['message' => 'Data updated successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>']);
            return view('pages.subscription.verify', ['data' => $data, 'subscriber' => $subscriber]);
        } catch (\Throwable $e) {
            $request->session()->flash('response', ['message' => 'Something went wrong, Please try later', 'class' => 'alert-danger', 'icon' => '<i class="fa fa-fw fa-times-circle"></i>']);
            return view('pages.subscription.verify', ['data' => $data, 'subscriber' => null]);
        }
    }

    public function verifySubscribtion(Request $request, $token)
    {
        $data = new \stdClass;
        $data->title = "Subscription | Update Data";
        $subscriber = Subscriber::where('token_verification', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                "subscribed_at" => now(),
                "token_verification" => null
            ]);
        }
        return view('pages.subscription.verify', ['data' => $data, 'subscriber' => $subscriber]);
    }

    public function subscribe(Request $request)
    {
        $subscriber_email = $request->subscriber_email;
        $subscriber = Subscriber::where('email', $subscriber_email)->first();
        if ($subscriber && $subscriber->token_verification == null) {
            return ['message' => 'Already subscribed!', 'subscriber' => $subscriber, 'class' => 'text-warning'];
        }

        $token = \Str::random(70);
        $url = \URL::to("/subscribers/verify/$token");

        $data = ['name'=>"Driss Boumlik", 'url' => $url, 'email' => $subscriber_email];
        Mail::send('mail', $data, static function ($message) use ($subscriber_email) {
            $message->to($subscriber_email, '')
                ->subject('Testing Subscribing');
            $message->from('blog@mail.com', 'Driss Boumlik');
        });

        $subscriber = Subscriber::updateOrCreate(['email' => $subscriber_email], ['token_verification' => $token]);

        return ['message' => 'Thank you for subscribing<br/>A confirmation email has been sent!', 'subscriber' => $subscriber, 'class' => 'text-success']; //'fa fa-fw fa-circle-check me-1'];
    }
}
