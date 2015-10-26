<?php

/**
 * Register Twig
 */
$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views'
]);

/**
 * Validator
 */
$app->register(new \Silex\Provider\ValidatorServiceProvider());
