<?php
namespace Horttcore\Rapidmail;

use Horttcore\Rapidmail\RapidmailApiInterface;

class RecipientList
{


    /**
     * API
     *
     * @var Horttcore\Rapidmail\RapidmailAPI
     */
    protected $api;


    /**
     * API endpoint
     *
     * @var string
     */
    protected $endpoint = 'recipientlists/%d';


    /**
     * Recipient list
     *
     * @var int
     */
    protected $recipientList;


    /**
     * Recipient list ID
     *
     * @var int
     */
    protected $recipientlistID;


    /**
     * Class constructor
     *
     * @param Api $api API layer
     * @param int $recipientlistID Recipient list ID
     * @return return type
     */
    public function __construct(RapidmailApiInterface $api, int $recipientlistID = 0)
    {
        $this->recipientlistID = $recipientlistID;
        $this->api = $api;

        if (!$recipientlistID) {
            return;
        }

        $this->recipientList = $this->get();
    }


    /**
     * Get recipient list
     *
     * @return return type
     */
    public function get()
    {
        if ( !$this->recipientList ) {
            $this->response = $this->api->get(sprintf($this->endpoint, $this->recipientlistID));
            $this->recipientList = $this->response;
        }

        return $this->recipientList;
    }
}
