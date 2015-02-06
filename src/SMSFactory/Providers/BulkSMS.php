<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders;

class BulkSMS implements ProviderInterface {

    /**
     * Using Curl client (you can make a change to Stream)
     */
    use ClientProviders\CurlTrait;

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
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return BulkSMS
     */
    final public function setRecipient($recipient) {
        $this->recipient    =   $recipient;

        return $this;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return BulkSMS
     */
    final public function setMessage($message) {
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
