<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactMeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email_details;
    /**
     * Create a new job instance.
     */
    public function __construct($email_details)
    {
        $this->email_details = $email_details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email_details = $this->email_details;
        Mail::send('emails.contact', $this->email_details, static function ($message) use ($email_details) {
            $message->to(env('MAIL_TO_ADDRESS'), 'Driss')
                ->subject('DB Contact Form : Message from ' . $email_details['name'])
                ->from(env('MAIL_FROM_ADDRESS'), 'DB Contact Form');
        });
    }
}
