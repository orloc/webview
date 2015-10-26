<?php

namespace Webview;

use GuzzleHttp\Client;
use Monolog\Logger;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Exception\BadResponseException;


/**
 * Class PageScraper
 * @package Webview
 */
class PageScraper {

    protected $log;

    /**
     * @param Logger $log
     */
    public function __construct(Logger $log){
        $this->log = $log;
    }

    /**
     * Does the scraping
     * @param $uri
     * @return array
     * @throws BadResponseException
     */
    public function scrapePage($uri){
        $client = new Client();

        $this->log->addDebug(sprintf('Attempting to fetch %s', $uri));

        try {
            $response = $client->get($uri);
            $dom = $response->getBody()->getContents();

            $data = $this->parseDom($dom);
            $this->log->addDebug(sprintf('SUCCESS - Fetched %s', $uri));

            return $data;

        } catch (BadResponseException $e){
            $this->log->addError(sprintf('ERROR %s - Fetching %s with %s', $e->getCode(), $uri, $e->getMessage()));
            throw $e;
        }
    }

    /**
     * Counts DOM elements and trims raw result
     * @param $dom
     * @return array
     */
    protected function parseDom($dom){
        $crawler = new Crawler($dom);

        $data = [];
        foreach ($crawler->filter('*') as $elm){
            if (!isset($data[$elm->tagName])){
                $data[$elm->tagName] = 0;
            }

            $data[$elm->tagName]++;
        }

        return [
            'raw' => trim($dom," \n\t\s"),
            'totals' => $data
        ];
    }



}