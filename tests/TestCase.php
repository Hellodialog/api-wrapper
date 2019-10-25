<?php
namespace Hellodialog\ApiWrapper\Test;

use Hellodialog\ApiWrapper\HelloDialogApi;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    /**
     * @var ClientInterface|
     */
    protected $mockClient;

    /**
     * List of mocked responses in order for mock Guzzle client handler.
     *
     * @var array
     */
    protected $mockResponses = [];

    /**
     * Guzzle history spy container.
     *
     * @var array
     */
    protected $historyContainer = [];

    /**
     * @var LoggerInterface|\Mockery\MockInterface|\Mockery\Mock
     */
    protected $mockLogger;


    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('hellodialog', [
            'url'              => 'localhost-api.test',
            'token'            => 'abcdef0123456789',
            'sender'           => [
                'email' => 'no-reply@test-hellodialog.com',
                'name'  => 'Test',
            ],
            'default_template' => 'transactional',
            'templates'        => [
                'transactional' => [
                    'id' => 1,
                ],
            ],
            'queue'            => false,
        ]);
    }

    public function tearDown()
    {
        $this->historyContainer = [];

        parent::tearDown();
    }

    /**
     * @param null|string $path
     * @return HelloDialogApi
     */
    protected function makeHelloDialogApi($path = 'transactional')
    {
        $mock = new MockHandler($this->mockResponses);

        $history = Middleware::history($this->historyContainer);
        $handler = HandlerStack::create($mock);

        $handler->push($history);

        $client = new Client(['handler' => $handler]);

        return (new HelloDialogApi($this->mockLogger))
            ->setClient($client)
            ->setType($path);
    }

    /**
     * @param mixed $content
     * @param int   $statusCode
     * @param array $headers
     * @return Response
     */
    protected function makeResponse(
        $content,
        $statusCode = 200,
        $headers = ['Content-Type' => 'application/json']
    ) {
        return new Response($statusCode, $headers, $content);
    }

    /**
     * @param mixed|string $content
     * @return Response
     */
    protected function makeJsonResponse($content)
    {
        return $this->makeResponse(json_encode($content));
    }

    /**
     * @param int         $code
     * @param null|string $message
     * @return Response
     */
    protected function makeErrorResponse($code, $message = null)
    {
        return $this->makeJsonResponse([
            'result' => [
                'status'  => 'ERROR',
                'code'    => $code,
                'message' => $message,
            ],
        ]);
    }

    /**
     * @param int $expected
     */
    protected function assertIsApiHistoryCount($expected)
    {
        static::assertCount($expected, $this->historyContainer, "{$expected} request(s) should have been made");
    }

    /**
     * @param string      $expectedMethod
     * @param int         $index
     * @param string|null $message
     */
    protected function assertIsApiHistoryEntryCorrectRequestOfMethod($expectedMethod, $index = 0, $message = null)
    {
        static::assertArrayHasKey($index, $this->historyContainer, "{$index} is invalid index for request history");

        $historyRecord = $this->historyContainer[ $index ];

        static::assertIsApiRequestOfMethod($expectedMethod, $historyRecord['request'], $message);
        static::assertFalse($historyRecord['options']['verify'], 'SSL verify option should be disabled');
    }

    /**
     * @param string      $expectedMethod
     * @param Request     $actual
     * @param string|null $message
     */
    protected static function assertIsApiRequestOfMethod($expectedMethod, $actual, $message = null)
    {
        $message = $message ? $message . '. ' : '';

        static::assertInstanceOf(Request::class, $actual, $message . 'Not a request object.');

        static::assertEquals($expectedMethod, $actual->getMethod(), $message . 'Method is incorrect');
        static::assertEquals('localhost-api.test/transactional', $actual->getUri()->getPath(), $message
            . 'Path is incorrect.');
        static::assertEquals('token=abcdef0123456789', $actual->getUri()->getQuery(), $message
            . 'Query string is incorrect.');
    }

}
