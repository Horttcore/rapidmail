<?php
namespace RalfHortt\Rapidmail;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Camspiers\JsonPretty\JsonPretty;

class Rapidmail implements RapidmailApiInterface
{


    /**
     * API base uri
     *
     * @var string
     */
    protected $baseURI = 'https://apiv3.emailsys.net';


    /**
     * Guzzle Client
     *
     * @var string
     */
    protected $client;


    /**
     * User password
     *
     * @var string
     */
    protected $password;


    /**
     * User name
     *
     * @var string
     */
    protected $user;


    /**
     * Class constructor
     *
     * @param string $user     User name
     * @param string $password User password
     * 
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;

        $this->client = new Client(
            [
                'base_uri' => $this->baseURI
            ]
        );

        $this->requestHeader = [
            'Accept' => 'application/json',
        ];

        $this->requestAuthentication = [
            $this->user, $this->password
        ];
    }


    /**
     * Build request array
     *
     * @param array $params Query parameters
     * 
     * @return array Request array
     */
    public function buildRequest($params)
    {
        $request['headers'] = $this->requestHeader;
        $request['auth'] = $this->requestAuthentication;
        $request = array_merge($request, $params);
        return $request;
    }


    /**
     * Send get request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Query parameters
     * 
     * @return object
     */
    public function get($endpoint, $params = [])
    {
        return $this->request($endpoint, ['query' => $params]);
    }


    /**
     * Send patch request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Query parameters
     * 
     * @return object
     */
    public function patch($endpoint, $params = [])
    {
        return $this->request($endpoint, $params, 'patch');
    }


    /**
     * Send post request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Request parameters
     * 
     * @return object
     */
    public function post($endpoint, $params = [])
    {
        return $this->request($endpoint, $params, 'post');
    }

    /**
     * Send delete request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Request parameters
     * 
     * @return object
     */
    public function delete($endpoint, $params = [])
    {
        return $this->request($endpoint, $params, 'delete');
    }

    /**
     * Request
     *
     * @param string $endpoint Endpoint
     * @param array  $params   Query parameters
     * @param string $method   Request type
     * 
     * @return object
     */
    public function request($endpoint, $params = [], $method = 'get')
    {
        try {
            $response = $this->client->$method($endpoint, $this->buildRequest($params));
            return \json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            if (!$e->hasResponse()) {
                return false;
            }

            $pretty = new JsonPretty();
            echo $pretty->prettify((string)$e->getResponse()->getBody()) . PHP_EOL;
        }
    }
}
