<?php

$app->get('/', function() use ($app){
    return $app['twig']->render('app.html.twig');
});

