<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Librarys\Sms;

class TestSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $admin_id;
    private $type;
    private $param;
    private $phone;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($admin_id, $type, $param, $phone)
    {
        $this->admin_id = $admin_id;
        $this->type = $type;
        $this->param = $param;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Sms::sendSms($this->admin_id, $this->type, $this->param, $this->phone);
    }
}
