<?php

namespace App\Jobs;

use Carbon\Carbon;
use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class CurrencyScrape implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $url = "https://kursdollar.org";

    protected array $json = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $response = $client->get($this->url);

        if ($response->getStatusCode() === 200) {
            $html = $response->getBody()->getContents();

            $dom = new DOMDocument('1.0');

            $html = str_replace('&nbsp;', ' ', $html);

            @$dom->loadHTML($html);

            $xpath = new DOMXPath($dom);

            $this->buildMeta($dom, $xpath);
            $this->buildRates($dom, $xpath);

            $this->generateJson();
        } else {
            throw $response->getBody();
        }
    }

    public function buildMeta(DOMDocument $dom, DOMXPath $xpath)
    {
        $elements = $xpath->query("//tr[@class='title_table']");

        $element = $elements?->item(0)?->childNodes;

        $word = str($element->item(5)->nodeValue)
            ->replace("Spot Dunia", "Spot Dunia ")
            ->value();

        $this->json['meta'] = [
            "date"      => Carbon::now()->format('d-m-Y'),
            "day"       => Carbon::now()->format('l'),
            "indonesia" => $element->item(3)?->nodeValue,
            "word"      => $word,
        ];
    }

    public function buildRates(DOMDocument $dom, DOMXPath $xpath)
    {
        $rates = [];

        $elements = $xpath->query("//table[@class='in_table']")->item(0);

        $trs = [];

        foreach ($elements->childNodes as $tr) {
            if ($tr->nodeName === "tr" && !empty($tr->nodeValue) && $tr->childNodes->length === 13) {
                $rates[] = $this->buildRate($tr);
            }
        }

        $this->json['rates'] = $rates;
    }

    public function buildRate(DOMNode $tr): array
    {
        $currency = str($tr->childNodes->item(1)->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->nodeValue)
            ->trim()
            ->value();

        $buy = str($tr->childNodes->item(3)->nodeValue)
            ->explode(" ")
            ->first();

        $sell = str($tr->childNodes->item(5)->nodeValue)
            ->explode(" ")
            ->first();

        $average = str($tr->childNodes->item(7)->nodeValue)
            ->explode(" ")
            ->first();

        $word_rate = str($tr->childNodes->item(9)->nodeValue)
            ->value();

        return [
            "currency" => $currency,
            "buy" => $this->normalizeNumber($buy),
            "sell" => $this->normalizeNumber($sell),
            "average" => $this->normalizeNumber($average),
            "word_rate" => $this->normalizeNumber($word_rate),
        ];
    }

    public function generateJson()
    {
        $date = Carbon::now()->format('d-m-Y');
        $time = Carbon::now()->format('H-i-s');

        $fileName = "currency/rate-$date--$time.json";

        return Storage::disk('public')->put($fileName, json_encode($this->json, JSON_PRETTY_PRINT));
    }

    public function normalizeNumber($number): float
    {
        return (float) str_replace(',', '.', str_replace('.', '', $number));
    }
}
