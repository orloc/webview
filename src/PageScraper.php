<?php

namespace Webview;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Exception\BadResponseException;


/**
 * Class PageScraper
 * @package Webview
 */
class PageScraper {

    protected $client;

    protected $crawler;

    protected $log;

    /**
     * @param Client $client
     * @param Crawler $crawler
     * @param LoggerInterface $log
     */
    public function __construct(Client $client, Crawler $crawler, LoggerInterface $log){
        $this->client = $client;
        $this->crawler = $crawler;
        $this->log = $log;
    }

    /**
     * Does the scraping
     * @param $uri
     * @return array
     * @throws BadResponseException
     */
    public function scrapePage($uri){
        $this->log->debug(sprintf('Attempting to fetch %s', $uri));

        try {
            $response = $this->client->get($uri);
            $dom = $response->getBody()->getContents();

            $data = $this->parseDom($dom);
            $this->log->debug(sprintf('SUCCESS - Fetched %s', $uri));

            return $data;
        } catch (BadResponseException $e){
            $this->log->error(sprintf('ERROR %s - Fetching %s with %s', $e->getCode(), $uri, $e->getMessage()));
            throw $e;
        }
    }

    /**
     * Counts DOM elements and trims raw result
     * @param $dom
     * @return array
     */
    protected function parseDom($dom){
        $data = [];

        $this->crawler->add($dom);

        foreach ($this->crawler->filter('*') as $elm){
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