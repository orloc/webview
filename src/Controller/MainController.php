<?php

namespace Webview\Controller;


use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class MainController implements ControllerProviderInterface {

    protected $app;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function connect(Application $app){
        $controllers = $app['controllers_factory'];

        $controllers->get('/', [$this, 'defaultAction']);
        $controllers->post('/search', [$this, 'searchAction']);

        return $controllers;
    }

    public function defaultAction(){
        return $this->app['twig']->render('page.html.twig');
    }

    public function searchAction(Request $request){
        $search =  $request->request->get('search', null);

        $errors = $this->app['validator']->validate($search, new Assert\Url());

        if (count($errors) > 0){
            // we know there can only be one invalid field
            $e = array_shift($errors->getIterator()->getArrayCopy());
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }

        $scraper = $this->app['webview.scraper'];
        die;


        /*
        $client = new Client();

        try {
            $response = $client->get($search);

            $dom = $response->getBody()->getContents();

            $crawler = new Crawler($dom);

            $data = [];
            foreach ($crawler->filter('*') as $elm){
                if (!isset($data[$elm->tagName])){
                    $data[$elm->tagName] = 0;
                }

                $data[$elm->tagName]++;
            }

            $returnData = [
                'raw' => trim($dom," \n\t\s"),
                'totals' => $data
            ];

            return new JsonResponse($returnData);

        } catch (BadResponseException $e){
            return new JsonResponse(['message' => $e->getMessage()], $e->getCode());
        }
        */

    }
}