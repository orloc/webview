<?php

/**
 * Register Twig
 */
$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views'
]);
