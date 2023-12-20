<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Storage;

class ClearCurrencyData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger('Clearing currency data');
        $directory = 'storage';
        $files = Storage::disk('public')->allFiles();
        foreach ($files as $file) {
            logger('Deleting '.$file);
            Storage::disk('public')->delete($file);
        }
        Redis::publish('clear-currency-data', json_encode(['message' => 'Data berhasil dihapus']));
        logger('Currency data cleared');
    }
}
