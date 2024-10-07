<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\IpUtils;

class ContactController extends Controller
{
    public function getInTouch(Request $request)
    {
        $request->validate([
            "name"                  => "required|max:100",
            "email"                 => "required|email|max:255",
            "body"                  => "required|max:200",
            "g-recaptcha-response"  => "required",
        ], [
            "body" => "The message must not be greater than 200 characters."
        ]);
        try {
            $this->checkCaptcha($request);

            $request_data = $request->only('name', 'email', 'body');
            Message::create($request_data);

            Mail::send('emails.contact', $request_data, static function ($message) use ($request_data) {
                $message->to(env('MAIL_TO_ADDRESS'), 'DB')
                    ->subject('DB Contact Form : Message from ' . $request_data['name'])
                    ->from(env('MAIL_FROM_ADDRESS'), 'DB Contact Form');
            });

            return response()->json(['message' => 'Message sent successfully', 'class' => 'tc-alert-ok', 'icon' => '<i class="fa fa-fw fa-circle-check tc-blue"></i>'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Something went wrong, Please try again!', 'class' => 'tc-orange-red', 'icon' => '<i class="fa fa-fw fa-times-circle tc-orange-red"></i>'], 400);
        }
    }

    private function checkCaptcha(Request $request)
    {
        $response = \Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->get('g-recaptcha-response'),
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ]);
        $result = json_decode($response);
        if (!$response->successful() || !$result->success) {
            throw new \Exception("Issue with captcha, Try again !");
        }
    }
}
