<?php

/**
 * Routing Definitions
 */

require __DIR__.'middleware.php';

$controller = new \Webview\Controller\MainController($app);


$controller->connect($app)
    ->before(checkPostContent());

