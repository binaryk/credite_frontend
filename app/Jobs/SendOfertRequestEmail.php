<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailers\Mailer;

class SendOfertRequestEmail extends Job implements SelfHandling, ShouldQueue
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
        $this->formData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Order::create([
            'user_id' => '',
            'email' => $this->formData['email'],
            'name' => $this->formData['name'],
            'phone' => $this->formData['phone'],
            'flight_nr' => '',
            'coming_from' => '',
            'resident_phone' => '',
            'from' => $this->formData['from'],
            'from_nr' => $this->formData['from_nr'],
            'to' => $this->formData['to'],
            'to_nr' => $this->formData['to_nr'],
            'to_street' => '',
            'up_date_time' => $this->formData['up_date_time'],
            'nr_passegers' => '',
            'nr_luggages' => '',
            'nr_hand_luggages' => '',
            'details' => $this->formData['details'],
            'meet_and_greet' => @$this->formData['meet_and_greet'],
            'return_50' => @$this->formData['return_50'],
            'pay_cash' =>  '',
            'request' => 1,
        ]);
        $mailler = new Mailer();
        $mailler->sendTo(
            config('owner.email'),
            'New ofert request',
            'emails.request.confirmare',
            [
                'body' => view('emails.request.email-content')->with([
                    'data'          => $this->formData,
                ])->render(),
                'client'  => null,
            ]
        );

    }
}
