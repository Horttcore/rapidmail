<?php
namespace RalfHortt\Rapidmail;

use RalfHortt\Rapidmail\RapidmailApiInterface;

class Mailing
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
    protected $endpoint = 'mailings';


    /**
     * Mailing ID
     *
     * @var int
     */
    protected $mailingId;


    /**
     * Mailing object
     *
     * @var object
     */
    protected $mailing;


    /**
     * Class constructor
     *
     * @param Api $api       API layer
     * @param int $mailingId Mailing ID
     */
    public function __construct(RapidmailApiInterface $api, int $mailingId = null)
    {
        $this->api = $api;
        $this->mailingId = $mailingId;
        $this->mailing = new \stdClass;
    }


    /**
     * Get mailing
     *
     * @param int $mailingId Mailing ID
     * 
     * @return object Mailing object
     */
    public function get(int $mailingId = null)
    {
        if ($mailingId) {
            $this->mailingId = $mailingId;
        }

        $this->mailing = $this->api->get(sprintf('%s/%d', $this->endpoint, $this->mailingId));

        return $this;
    }


    /**
     * Get mailing property
     * 
     * @param string $property Property
     *
     * @return object Mailing object
     */
    public function __get(string $property)
    {
        if (!isset($this->mailing->$property)) {
            throw new \Exception('Unknown property');
        }

        return $this->mailing->$property;
    }


    /**
     * Set mailing property
     * 
     * @param string $property Property
     * @param mixed  $value    Value
     *
     * @return object Mailing object
     */
    public function __set($property, $value): void
    {
        if (!method_exists($this, 'set' . $property)) {
            throw new \Exception('Unknown property');
        }

        call_user_func([$this, 'set' . $property], $value);
    }


    /**
     * Set from name
     *
     * @param string $value From name
     * 
     * @return void
     */
    protected function setFromName(string $value): void
    {
        $this->mailing->from_name = filter_var($value, FILTER_SANITIZE_STRING);
    }


    /**
     * Set from email
     *
     * @param string $value From email
     * 
     * @return void
     */
    protected function setFromEmail(string $value): void
    {
        $this->mailing->from_email = filter_var($value, FILTER_SANITIZE_EMAIL);
    }


    /**
     * Set subject
     *
     * @param string $value Subject
     * 
     * @return void
     */
    protected function setSubject(string $value): void
    {
        $this->mailing->subject = filter_var($value, FILTER_SANITIZE_STRING);
    }


    /**
     * Set send date
     *
     * @param string $value Send date in the format Y-m-d H:i:s
     * 
     * @return void
     */
    protected function setSendAt(string $value): void
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = new \DateTime($value);
        $this->mailing->send_at = $value->format('Y-m-d\TH:i:s');
    }


    /**
     * Set robinsonlist checking
     *
     * @param bool $value Robinsonlist checking
     * 
     * @return void
     */
    protected function setCheckRobinson(bool $value): void
    {
        $this->mailing->check_robinson = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * Set austrian ECG list checking (only for austria)
     *
     * @param bool $value CG list checking
     * 
     * @return void
     */
    protected function setCheckEcg(bool $value): void
    {
        $this->mailing->check_ecg = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * Set Hostname to use. Must be a valid and confirmed hostname. If omitted, default user hostname will be used.
     *
     * @param bool $value Hostname
     * 
     * @return void
     */
    protected function setHost(string $value): void
    {
        $this->mailing->host = filter_var($value, FILTER_SANITIZE_STRING);
    }


    /**
     * Set if the mailing is a A/B split mailing
     *
     * @param bool $value Attachments count
     * 
     * @return void
     */
    protected function setFeatureMailingsplit(bool $value): void
    {
        $this->mailing->feature_mailingsplit = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * Set attachments count
     *
     * @param int $value Attachments count
     * 
     * @return void
     */
    protected function setAttachments(int $value): void
    {
        $this->mailing->attachments = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }


    /**
     * Set file
     *
     * @param string $value Path to zip file 
     * 
     * @return void
     */
    protected function setFile(string $value): void
    {
        if (!file_exists($value)) {
            throw new \Exception('File does not exists');
        }

        if (!is_readable($value)) {
            throw new \Exception('File is not readable');
        }

        $file = new \stdClass;
        $file->content = base64_encode(file_get_contents($value));
        $file->type = 'application/zip';
        $this->mailing->file = $file;
    }


    /**
     * Set status
     *
     * @param string <draft|scheduled> $value Status 
     * 
     * @return void
     */
    protected function setStatus(string $value): void
    {
        if ('draft' != $value && 'scheduled' != $value) {
            throw new \Exception('Invalid value for status');
        }

        $this->mailing->status = filter_var($value, FILTER_SANITIZE_STRING);
    }


    /**
     * Set recipient list ID
     *
     * @param string $value Recipient list ID
     * 
     * @return void
     */
    protected function setRecipientListId(string $value): void
    {
        $recipient = new \stdClass;
        $recipient->type = 'recipientlist';
        $recipient->id = filter_var($value, FILTER_SANITIZE_STRING);
        $recipient->action = 'include';

        $this->mailing->destinations = [
            $recipient
        ];
    }


    /**
     * Pause scheduled mailing
     *
     * @todo
     * @return void
     */
    public function save()
    {
        return $this->api->post($this->endpoint, ['json' => $this->mailing]);
    }


    /**
     * Pause scheduled mailing
     *
     * @todo
     * @return void
     */
    public function pause()
    {
        //
    }


    /**
     * Get mailing
     *
     * @todo
     * @return void
     */
    public function cancel()
    {
        //
    }
}
