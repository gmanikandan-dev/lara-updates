<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayment implements ShouldBeUniqueUntilProcessing, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* configurations reference */
    public $connection = 'redis';

    public $queue = 'notifications';

    public $backoff = 30;

    public $timeout = 60;

    public $tries = 3;

    public $delay = 300;

    public $afterCommit = true;

    public $shouldBeEncrypted = true;

    public $uniqueId = 'products';

    public $uniqueFor = 10;

    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $name)
    {
        info("Name : {$name}");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }

    public function uniqueId()
    {
        return $this->product->id;
    }

    public function retryUntil()
    {
        return now()->addDay();
    }
}
