<?php
namespace RalfHortt\Rapidmail;

use RalfHortt\Rapidmail\RapidmailApiInterface;

class Recipients
{


    /**
     * API
     *
     * @var RalfHortt\Rapidmail\RapidmailAPI
     */
    protected $api;


    /**
     * API endpoint
     *
     * @var string
     */
    protected $endpoint = 'recipients';


    /**
     * Query args
     *
     * @var array
     */
    protected $query = [];


    /**
     * Recipient list ID
     *
     * @var integer
     */
    protected $recipientListId = 0;


    /**
     * Class constructor
     *
     * @param RapidmailApiInterface $api             API layer
     * @param int                   $recipientListId Recipient list ID
     * 
     * @return RecipientLists
     */
    public function __construct(RapidmailApiInterface $api, int $recipientListId)
    {
        $this->api = $api;
        $this->recipientListId = $recipientListId;
    }


    /**
     * Get recipient lists
     *
     * @param array $query Query
     * 
     * @return array Recipient lists
     */
    public function get(array $query = [])
    {
        $this->query = array_filter(
            array_replace(
                [
                    'email' => '',
                    'foreign_id' => '',
                    'page' => '',
                    'sort_by' => '',
                    'sort_order' => '',
                    'status' => '',
                    'get_extra_big_fields' => '',
                ],
                $query
            )
        );

        $this->query['recipientlist_id'] = $this->recipientListId;

        return $this->api->get($this->endpoint, $this->query);
    }
}
