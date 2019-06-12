<?php
namespace RalfHortt\Rapidmail;

use RalfHortt\Rapidmail\RapidmailApiInterface;

class Recipient
{

    /**
     * API
     *
     * @var RalfHortt\Rapidmail\RapidmailApiInterface
     */
    protected $api;

    /**
     * API endpoint
     *
     * @var string
     */
    protected $endpoint = 'recipients';

    /**
     * Recipient Id
     *
     * @var int
     */
    protected $recipientId = 0;

    /**
     * Recipient properties
     *
     * @var array
     */
    protected $properties = [
        'id',
        'email',
        'recipientlist_id',
        'firstname',
        'lastname',
        'gender',
        'title',
        'zip',
        'birthdate',
        'foreign_id',
        'mailtype',
        'extra1',
        'extra2',
        'extra3',
        'extra4',
        'extra5',
        'extra6',
        'extra7',
        'extra8',
        'extra9',
        'extra10',
        'extrabig1',
        'extrabig2',
        'extrabig3',
        'extrabig4',
        'extrabig5',
        'extrabig6',
        'extrabig7',
        'extrabig8',
        'extrabig9',
        'extrabig10',
        'created_ip',
        'created_hostname',
        'activated'
    ];

    /**
     * Recipient list ID
     *
     * @var int
     */
    protected $recipientListId;

    /**
     * Recipient object
     *
     * @var object
     */
    protected $recipient;

    /**
     * Class constructor
     *
     * @param RapidmailApiInterface $api         API layer
     * @param int                   $recipientId Recipient ID
     */
    public function __construct(RapidmailApiInterface $api, int $recipientId = 0)
    {
        $this->api = $api;
        $this->recipientId = $recipientId;
        $this->recipient = new \stdClass;
    }

    /**
     * Get Recipient property
     * 
     * @param string $property Property
     *
     * @return object Recipient object
     */
    public function __get(string $property)
    {
        if (!in_array($property, $this->properties)) {
            throw new \Exception(sprintf('Unknown property: %s', $property));
        }

        return $this->recipient->$property;
    }


    /**
     * Set Recipient property
     * 
     * @param string $property Property
     * @param mixed  $value    Value
     *
     * @return object Recipient object
     */
    public function __set($property, $value)
    {

        if (!in_array($property, $this->properties)) {
            throw new \Exception(sprintf('Unknown property: %s', $property));
        }

        $this->recipient->$property = $value;
    }

    /**
     * Get Recipient
     *
     * @return Recipient Recipient object
     */
    public function get(int $recipientId = 0)
    {
        if ($recipientId) {
            $this->recipientId = $recipientId;
        }

        $this->recipient = $this->api->get(sprintf('%s/%d', $this->endpoint, $this->recipientId));

        return $this;
    }

    /**
     * Delete a recipient
     * 
     * @return object response object
     */
    public function delete()
    {
        if( $this->recipientId == 0) {
            return;
        }

        $response = $this->api->delete(sprintf('%s/%d', $this->endpoint, $this->recipientId));
        return $response;
    }




    /**
     * Save a recipient
     * 
     * @param array $options Recipient options
     
     * @return object Recipient object
     * 
     * @todo Update an already existing user
     */
    public function save(array $options = [])
    {
        $data = ['json' => $this->recipient] + $options;
        $response = $this->api->post($this->endpoint, $data);

        if (!isset($response->id)) {
            return $this;
        }

        $this->recipient = $response;
    }
}
