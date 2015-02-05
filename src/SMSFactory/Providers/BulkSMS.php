<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use Phalcon\Http\Client\Provider\Curl;
use SMSFactory\Aware\CurlTrait;

class BulkSMS implements ProviderInterface {

    use CurlTrait;

    /**
     * Url to access to service
     *
     * @var string
     */
    private $url    =   'http://bulksms.vsms.net:5567/eapi/submission/send_sms/2/2.0';

    /**
     * Recipient of message
     *
     * @var null|int
     */
    private $recipient  =   null;

    /**
     * Text Message
     *
     * @var string
     */
    private $message  =   '';

    /**
     * You may reconfigure server url from outer call
     *
     * @param string $url
     * @return BulkSMS
     */
    public function setUrl($url) {
        $this->url  =   $url;

        return $this;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return BulkSMS
     */
    public function setRecipient(int $recipient) {
        $this->recipient    =   $recipient;

        return $this;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return BulkSMS
     */
    public function setMessage($message) {
        $this->message    =   $message;

        return $this;
    }

    /**
     * Final send function
     *
     * @param array $params additional parameters
     * @return void
     */
    final public function send(array $params = []) {

    }
}
