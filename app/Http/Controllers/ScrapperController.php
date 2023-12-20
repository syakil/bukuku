<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;
use App\Interfaces\ScrapperInterface;
use Storage;
use App\Jobs\ClearCurrencyData;

class ScrapperController extends Controller
{
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

    public function clearStoredData()
    {
        ClearCurrencyData::dispatch()->onQueue('clear-currency-data');
        return 'Proses berhasil ditambahkan pada Job';
    }

}
