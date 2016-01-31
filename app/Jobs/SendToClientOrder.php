<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailers\Mailer;

class SendToClientOrder extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $formData = null;
    public function __construct($data)
    {
        if(!array_key_exists('meet_and_greet', $data)){
            $data['meet_and_greet'] = '0';
        }
        if(!array_key_exists('return_50', $data)){
            $data['return_50'] = '0';
        }
        if(!array_key_exists('pay_cash', $data)){
            $data['pay_cash'] = '0';
        }
        $this->formData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailler = new Mailer();
        $mailler->sendTo(
            $this->formData['email'],
            'Your order',
            'emails.extern.confirmare',
            [
                'body' => view('emails.extern.email-content')->with([
                    'data'          => $this->formData,
                ])->render(),
                'data' => $this->formData,
            ]
        );

    }
}
