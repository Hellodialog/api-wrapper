<?php
namespace Hellodialog\ApiWrapper;

use Hellodialog\ApiWrapper\config\Hellodialog;
use Hellodialog\ApiWrapper\Contracts\HelloDialogApiInterface;
use Hellodialog\ApiWrapper\Enums\ApiType;
use Hellodialog\ApiWrapper\Exceptions\ConnectionException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class HelloDialogApi
 *
 * Formerly known as KBApi. To use this outside of laravel,
 * be sure to pass in all constructor parameters
 */
class HelloDialogApi implements HelloDialogApiInterface
{

    protected $hdSettings;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * API Token
     *
     * @var string
     */
    protected $token = null;

    /**
     * API Location
     *
     * @var string
     */
    protected $url = null;

    /**
     * API sub-path / action
     *
     * @var string
     */
    protected $path = null;

    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * @var array
     */
    protected $parameter = [];

    /**
     * @var integer
     */
    protected $page = 0;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Which condition keys are valid
     *
     * @var array
     */
    protected $validConditions = [
        'equals',
        'equals-any',
        'not-equals',
        'greater-than',
        'less-than',
        'contains',
        'not-contains',
        'starts-with',
        'ends-with',
        'before',
        'after',
        'contains-any',
        'contains-all',
        'contains-exactly',
        'not-contains-any',
        'not-contains-all',
    ];

    /**
     * Guzzle client
     *
     * @var null|ClientInterface
     */
    protected $client;

    /**
     * @var null|Exceptions\HelloDialogErrorException
     */
    protected $lastError;


    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: app('log');
        $this->hdSettings = new Hellodialog();
        $this->path  = ApiType::TRANSACTIONAL;
        $this->token = $this->hdSettings->getToken();
        $this->url   = $this->hdSettings->getUrl();
    }

    /**
     * @return Hellodialog
     */
    public function getHdSettings()
    {
        return $this->hdSettings;
    }

    /**
     * @param Hellodialog $hdSettings
     */
    public function setHdSettings($hdSettings)
    {
        $this->hdSettings = $hdSettings;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->path = $type;

        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Clears conditions and data
     *
     * @return $this
     */
    public function clear()
    {
        $this->conditions = [];
        $this->data       = [];

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Sets a key value pair with a given condition
     *
     * @param string $key
     * @param mixed  $value
     * @param string $condition
     * @return $this
     * @throws Exception
     */
    public function condition($key, $value, $condition = 'equals')
    {
        if ( ! in_array($condition, $this->validConditions)) {
            throw new Exception("'{$condition}' is not a valid condition");
        }

        $this->conditions[ $key ] = [
            'value'     => $value,
            'condition' => $condition,
        ];

        return $this;
    }

    /**
     * Performs a request for the PUT method
     *
     * @param string $id
     * @return mixed
     * @throws ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($id = null)
    {
        return $this->request('PUT', $id);
    }

    /**
     * Performs a request for the DELETE method
     *
     * @param string $id
     * @return mixed
     * @throws ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->request('DELETE', $id);
    }

    /**
     * Performs a request for the GET method
     *
     * @param string $id
     * @return mixed
     * @throws ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($id = null)
    {
        return $this->request('GET', $id);
    }

    /**
     * Performs a request for the POST method
     *
     * @return mixed
     * @throws ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post()
    {
        return $this->request('POST');
    }

    /**
     * Performs a request to the API
     *
     * @param string $method
     * @param string $id
     * @return mixed
     * @throws ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($method, $id = null)
    {
        $this->lastError = null;

        $this->checkBeforeRequest();

        // mock the call instead?
        /*if (config('hellodialog.mock')) {
            $this->logger->debug("Mocked {$method} request to HelloDialog.", [
                'id'         => $id,
                'data'       => $this->data,
                'conditions' => $this->conditions,
            ]);

            return $this->makeMockResponse();
        }*/

        // prepare the URL
        $url = $this->getBaseUrl();

        if ($id) {
            $url = rtrim($url, '/') . '/' . $id;
        }


        try {
            $response = $this->client->request($method, $url, $this->buildGuzzleOptions($method));

        } catch (ClientException $e) {

            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->handleResponse($response);

        // todo: remove old code after testing
        //    $requestUrl .= '&condition[' . $key . ']='
        //                 . $data['condition'] . '&values[' . $key . ']='
        //                 . urlencode($data['value']);
    }

    /**
     * Checks conditions and properties before performing a request
     *
     * @throws Exception
     */
    protected function checkBeforeRequest()
    {
        if ( ! $this->client) {
            $this->client = $this->buildGuzzleClient();
        }

        if (empty($this->path)) {
            throw new Exception("No url specified");
        }

        if (empty($this->token)) {
            throw new Exception("API token is required");
        }
    }

    /**
     * Builds and returns the guzzle options to send with a request
     *
     * @param string $method
     * @return array
     */
    protected function buildGuzzleOptions($method = 'GET')
    {
        $options = [
            'verify' => false, //config('hellodialog.client.verify-ssl', false),
        ];

        // set data in body for PUT, POST or PATCH
        if (in_array($method, ['PATCH', 'POST', 'PUT'])) {
            $options['body'] = json_encode($this->data);
        }

        // always set request parameters
        $requestParameters = [
            'token' => $this->token,
        ];

        if(isset($this->parameter) && !empty($this->parameter)) {
            foreach ($this->parameter as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $filter => $option) {
                        $requestParameters[$filter] = $option;
                    }
                }
            }
        }

        foreach ($this->conditions as $key => $data) {
            $requestParameters[ 'condition[' . $key . ']' ] = $data['condition'];
            $requestParameters[ 'values[' . $key . ']' ]    = $data['value'];
        }

        $page = $this->page();
        if($page !== false && is_array($page)) {
            $requestParameters['page'] = $page['page'];
        }

        $options['query'] = $requestParameters;
        return $options;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws Exceptions\ConnectionException
     * @throws Exceptions\HelloDialogErrorException
     */
    protected function handleResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            throw new Exceptions\ConnectionException("Received unexpected status code: {$response->getStatusCode()}");
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        if ( ! is_array($responseArray)) {
            throw new Exceptions\ConnectionException("Received unexpected body content, invalid json.");
        }

        // detect error response
        if (strtolower(array_get($responseArray, 'result.status', '')) == 'error') {
            throw new Exceptions\HelloDialogErrorException(
                array_get($responseArray, 'result.message', null),
                array_get($responseArray, 'result.code', 0)
            );
        }

        return $responseArray;
    }

    /**
     * Returns standard mocked response that signifies a standard 'OK'
     *
     * @return array
     */
    protected function makeMockResponse()
    {
        return [
            'result' => [
                'code'    => 200,
                'message' => 'Mocked.',
            ],
        ];
    }

    /**
     * Returns the base URL + Path.
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->url . '/' . ltrim($this->path, '/');
    }

    /**
     * @return ClientInterface
     */
    protected function buildGuzzleClient()
    {
        return app(Client::class);
    }

    /**
     * Sets a page for 100 results per page
     *
     * @param $page
     * @return mixed
     */
    public function page($page = 0)
    {
        if($page > 0){
            return ['page' => $page];
        }

        return false;
    }

    /**
     * @param $key
     * @param mixed $value
     * @return mixed
     */
    public function parameter($key, $value = false)
    {
        $this->parameter[] = [$key => $value];
        if($value){
            return [$key => $value];
        }
        return $key;
    }
}
