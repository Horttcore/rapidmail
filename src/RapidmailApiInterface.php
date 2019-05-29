<?php
namespace Horttcore\Rapidmail;

interface RapidmailApiInterface {

   /**
     * Send get request
     *
     * @param string $endpoint Request endpoint
     * @param array $params
     * @return object
     */
    public function get($endpoint, $params = []);


    /**
     * Send patch request
     *
     * @param string $endpoint Request endpoint
     * @param array $params
     * @return object
     */
    public function patch($endpoint, $params);


    /**
     * Send post request
     *
     * @param string $endpoint Request endpoint
     * @param array $params
     * @return object
     */
    public function post($endpoint, $params);

}