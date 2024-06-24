<?php

namespace Src\Transactions\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public $tries = 15;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = 'https://util.devi.tools/api/v1/notify';

        $response = Http::post($url);
        
        $status = $response->status();
        
        if ($status == 204) {

            Log::info('Notification sent successfully.');

        } elseif ($status == 504) {

            $this->release(60);
            Log::warning('Notification service unavailable. Job will be rescheduled.');

        }
    }
}
