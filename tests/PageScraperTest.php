<?php

use \Symfony\Component\HttpKernel\Log\NullLogger;
use \Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use \GuzzleHttp\Client;

class PageScraperTest extends PHPUnit_Framework_TestCase{

    const TEST_URI = 'http://webview.dev';

    protected $mock_log;

    protected $crawler;

    public function setUp(){
        $this->mock_log = new NullLogger();
        $this->crawler = new Crawler();
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     */
    public function testNotFoundResponse(){

        $client = $this->getMockedClient(new Response(404));

        $scraper = new \Webview\PageScraper($client, $this->crawler, $this->mock_log);

        $scraper->scrapePage(self::TEST_URI);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ServerException
     */
    public function testErrorResponse(){

        $client = $this->getMockedClient(new Response(500));

        $scraper = new \Webview\PageScraper($client, $this->crawler, $this->mock_log);

        $scraper->scrapePage(self::TEST_URI);
    }

    public function testCountTags(){
        $data = trim($this->getFileData('html.html'));

        $client = $this->getMockedClient(new Response(200, [], $data));

        $scraper = new \Webview\PageScraper($client, $this->crawler, $this->mock_log);

        $result = $scraper->scrapePage(self::TEST_URI);

        $this->assertArrayHasKey('raw', $result);
        $this->assertArrayHasKey('totals', $result);
        $this->assertEquals($data, $result['raw']);


        $totals = $result['totals'];

        $this->assertCount(18,$totals);

        $this->assertArrayHasKey('script', $totals);
        $this->assertArrayHasKey('body', $totals);
        $this->assertArrayHasKey('button', $totals);

        $this->assertEquals(11, $totals['script']);
        $this->assertEquals(1, $totals['body']);
        $this->assertEquals(2, $totals['button']);
    }

    protected function getMockedClient(Response $response){
        $clientMock = new MockHandler([
            $response
        ]);

        $handler = HandlerStack::create($clientMock);

        return new Client(['handler' => $handler]);
    }

    protected function getFileData($name){
        return file_get_contents(
            implode(DIRECTORY_SEPARATOR, [__DIR__,"testData",$name])
        );
    }

}