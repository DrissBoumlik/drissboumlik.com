<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailDetails;
    /**
     * Create a new job instance.
     */
    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emailDetails = $this->emailDetails;
        Mail::send('emails.contact', $this->emailDetails, static function ($message) use ($emailDetails) {
            $message->to(env('MAIL_TO_ADDRESS'), 'DB')
                ->subject('DB Contact Form : Message from ' . $emailDetails['name'])
                ->from(env('MAIL_FROM_ADDRESS'), 'DB Contact Form');
        });
    }
}
