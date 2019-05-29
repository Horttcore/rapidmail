<?php
namespace Horttcore\Rapidmail;

use Horttcore\Rapidmail\RapidmailApiInterface;

class RecipientLists
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
    protected $endpoint = 'recipientlists';


    /**
     * Current page
     * 
     * Rapidmail API only retrieves 25 items per request
     *
     * @var int
     */
    protected $page = 1;


    /**
     * Number of recipient list pages
     *
     * @var int
     */
    protected $pageCount;


    /**
     * Items per recipient list page
     *
     * @var int
     */
    protected $pageSize;


    /**
     * Array of recipient list objects
     *
     * @var array
     */
    protected $recipientLists;


    /**
     * Recipient list count
     *
     * @var int
     */
    protected $totalItems;


    /**
     * Class constructor
     *
     * @param RapidmailApiInterface $api API layer
     * @param int $page Recipient list page
     * @return RecipientLists
     */
    public function __construct(RapidmailApiInterface $api, int $page = 1)
    {
        $this->api = $api;
        $this->page = $page;
    }


    /**
     * Get recipient lists
     *
     * @return array Recipient lists
     */
    public function get(): array
    {
        if ( !$this->recipientLists ) {
            $this->make();
        }

        return $this->recipientLists;
    }


    /**
     * Get all recipient lists
     *
     * @return array
     **/
    public function getAll(): array
    {
        $this->get();

        for  ( $i = 2; $i <= $this->pages(); $i++ ) {
            $list = new RecipientLists($this->api, $this->page() + 1);
            $this->recipientLists += $list->get(); 
        }

        return $this->recipientLists;
    }


    /**
     * Get recipient list count
     *
     * @return int
     */
    public function count(): int
    {
        return $this->totalItems;
    }


    /**
     * Make request
     *
     * @return void
     **/
    public function make(): void
    {
        $this->response = $this->api->get($this->endpoint, [
            'page' => $this->page
        ]);

        if ( !isset( $this->response->_embedded ) ) {
            return;
        }

        $this->pageCount = $this->response->page_count;
        $this->pages = $this->response->page_size;
        $this->totalItems = $this->response->total_items;
        $this->recipientLists = $this->response->_embedded->recipientlists;
    }


    /**
     * Current page
     *
     * @return int Page count
     */
    public function page(): int
    {
        return $this->page;
    }


    /**
     * Number of pages
     *
     * @return int Page count
     */
    public function pages(): int
    {
        return $this->pageCount;
    }


    /**
     * Number of items per page
     *
     * @return int Number of items per page
     */
    public function itemsPerPage(): int
    {
        return $this->page_size;
    }
}
