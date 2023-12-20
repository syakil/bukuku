<?php

namespace App\Repositories;

use Goutte\Client;
use App\Interfaces\ScrapperInterface;

class ScrapperRepository implements ScrapperInterface
{
    private $data = [];

    public function getScrappedData($url)
    {
        $client = new Client();
                $crawler = $client->request('GET', $url);
                $crawler->filter('.in_table tr')->each(function ($node) {
                    $cleanedText = preg_replace('/\s+/', ' ', trim($node->text()));
                    $this->data[] = $cleanedText;
                });

                $result = [];

                $result['meta'] = [$this->getMeta()];
                $result['rates'] = [$this->getCurrency()];
        return $result;
    }

    private function getMeta(){

            $string = $this->data[0];
            $string = str_replace(["\u{A0}", ','], [',', ' '], $string);
            $parts = explode(' ', $string);

            $originalDate = $parts[7] ."-".$this->ubahBulan($parts[8]) ."-". $parts[9];
            $date = date("d-m-Y", strtotime($originalDate));
            $day = date("l", strtotime($originalDate));;

            $meta = $this->data[1];
            $meta = explode("Spot Dunia", $meta);
            $meta[0] = explode("Mata Uang ", $meta[0]);

            return [
                'date' => $date,
                'day' => $day,
                'indonesia' => $meta[0][1],
                'word' => 'Spot Dunia '. $meta[1],
            ];
        }

        private function getCurrency(){
            $result = [];
            for ($i = 3; $i < 23; $i++) {
                $currencyData = explode(' ', $this->data[$i]);
                $currencyData[0] = str_replace("\u{A0}↑", '', $currencyData[0]);
                $currencyData[0] = str_replace("\u{A0}↓", '', $currencyData[0]);
                $currencyData[0] = str_replace("\u{A0}", '', $currencyData[0]);
                $newCurrencyData = [];
                foreach ($currencyData as $key => $value) {
                    if(!str_contains($value,'(')){
                        $newCurrencyData[] = $value;
                    }
                }
                $result[] = [
                    'currency' => $newCurrencyData[0],
                    'buy' => $newCurrencyData[1],
                    'sell' => $newCurrencyData[2],
                    'average' => $newCurrencyData[3],
                    'word_rate' => $newCurrencyData[4],
                ];
            }
            return $result;
        }

        private function ubahBulan($bulan){
            switch ($bulan) {
                case 'Januari':
                    return '01';
                    break;
                case 'Februari':
                    return '02';
                    break;
                case 'Maret':
                    return '03';
                    break;
                case 'April':
                    return '04';
                    break;
                case 'Mei':
                    return '05';
                    break;
                case 'Juni':
                    return '06';
                    break;
                case 'Juli':
                    return '07';
                    break;
                case 'Agustus':
                    return '08';
                    break;
                case 'September':
                    return '09';
                    break;
                case 'Oktober':
                    return '10';
                    break;
                case 'November':
                    return '11';
                    break;
                case 'Desember':
                    return '12';
                    break;
                default:
                    return '01';
                    break;
            }

        }
}
