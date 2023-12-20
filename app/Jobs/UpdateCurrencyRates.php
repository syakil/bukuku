<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Interfaces\ScrapperInterface;
use Carbon\Carbon;
use Storage;

class UpdateCurrencyRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private ScrapperInterface $scrapperInterface;
    public function __construct(ScrapperInterface $scrapperInterface)
    {
        $this->scrapperInterface = $scrapperInterface;
    }
    public function scrapper(){
        return response()->json($this->scrapperInterface->getScrappedData('https://kursdollar.org/'));
    }
    public function scrapperSaveData(){
        $result = $this->scrapper();
        $jsonResult = json_encode($result, JSON_PRETTY_PRINT);
        $filename = 'scrapper_result_' . Carbon::now('Asia/Jakarta')->format('d-m-Y--H-i-s') . '.json';
        Storage::disk('public')->put($filename, $jsonResult);

        return $filename;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger('Scrapper Job is running');
        $this->scrapperSaveData();
        logger('Scrapper Job is done');
    }
}
