<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailers\Mailer;

class RequestResponseEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $response = null;
    protected $request = null;
    public function __construct($response, $request)
    {
        $this->request = $request;
        $this->response= $response;
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
            $this->request->email,
            'Booking offer',
            'emails.request.response.confirmare',
            [
                'body' => view('emails.request.response.email-content')->with([
                    'data'          => $this->request,
                    'response'      => $this->response,
                ])->render(),
                'client'  => null,
            ]
        );

    }
}
