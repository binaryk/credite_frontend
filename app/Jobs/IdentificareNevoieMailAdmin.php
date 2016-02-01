<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailers\Mailer;

class IdentificareNevoieMailAdmin extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data = null;
    public function __construct($data)
    {
        $this->data = $data;
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
            'lupacescueduard@yahoo.com',
            'Identificarea nevoii',
            'emails.identificarea_nevoii.header',
            [
                'body' => view('emails.identificarea_nevoii.content')->with([
                    'data'          => $this->data,
                ])->render(),
                'client'  => null,
            ]
        );

    }
}
