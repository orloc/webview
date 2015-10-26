<?php

/**
 * Routing Definitions
 */

use \Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Renders html for Angular app
 */
$app->get('/', function() use ($app){
    return $app['twig']->render('page.html.twig');
});

/**
 * Handles form post
 */
$app->post('/search', function(Request $request) use ($app){
    var_dump($request->request->all());
    die;

})->before(function(Request $request, Application $app){
     // Decodes JSON Body content if present
    if (in_array($request->getMethod(), ['POST', 'PATCH']) && 0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

