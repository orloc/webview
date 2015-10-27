<?php

namespace Webview\Provider;

use GuzzleHttp\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\DomCrawler\Crawler;
use Webview\PageScraper;

/**
 * Exposes the scraper to the world
 * Class PageScraperProvider
 * @package Webview\Provider
 */
class PageScraperProvider implements ServiceProviderInterface {

    public function register(Application $app){
        $app['webview.scraper'] = $app->protect(function() use ($app){

            $client = new Client();
            $crawler = new Crawler();

            $scraper = new PageScraper($client, $crawler, $app['monolog']);

            return $scraper;
        });
    }

    public function boot(Application $app){

    }
}