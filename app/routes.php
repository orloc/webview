<?php

/**
 * Routing Definitions
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
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

    $search =  $request->request->get('search', null);

    $errors = $app['validator']->validate($search, new Assert\Url());

    if (count($errors) > 0){
        // we know there can only be one invalid field
        $e = array_shift($errors->getIterator()->getArrayCopy());
        return new JsonResponse(['message' => $e->getMessage()], 400);
    }

    



})->before(function(Request $request, Application $app){
     // Decodes JSON Body content if present
    if (in_array($request->getMethod(), ['POST', 'PATCH']) && 0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

