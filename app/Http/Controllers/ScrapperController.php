<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;
use App\Interfaces\ScrapperInterface;

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



}
