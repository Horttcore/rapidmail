<?php
namespace RalfHortt\Rapidmail;

interface RapidmailApiInterface
{

    /**
     * Send get request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Request parameters
     * 
     * @return object
     */
    public function get($endpoint, $params = []);


    /**
     * Send patch request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Request parameters
     * 
     * @return object
     */
    public function patch($endpoint, $params);


    /**
     * Send post request
     *
     * @param string $endpoint Request endpoint
     * @param array  $params   Request parameters
     * 
     * @return object
     */
    public function post($endpoint, $params);
}
