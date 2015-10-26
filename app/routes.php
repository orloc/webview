<?php

use \Symfony\Component\HttpFoundation\Request;

$app->get('/', function() use ($app){
    return $app['twig']->render('page.html.twig');
});

$app->post('/search', function(Request $request) use ($app){
    var_dump($request->request->all());
    die;

});

