<?php

/**
 * Routing Definitions
 */

require __DIR__.'/middleware.php';

$controller = new \Webview\Controller\MainController($app);


$factory = $controller->connect($app)
    ->before(checkPostContent());

$app->mount('', $factory);

