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

            var_dump(array_keys($app));die;
            $scaper = new PageScraper($app['lo']);
        });
    }

    public function boot(Application $app){

    }
}