<?php

namespace Webview\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Webview\PageScraper;

/**
 * Exposes the scraper to the world
 * Class PageScraperProvider
 * @package Webview\Provider
 */
class PageScraperProvider implements ServiceProviderInterface {

    public function register(Application $app){
        $app['webview.scraper'] = $app->protect(function() use ($app){
            $scraper = new PageScraper($app['monolog']);

            return $scraper;
        });
    }

    public function boot(Application $app){

    }
}