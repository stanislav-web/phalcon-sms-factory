<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Config\SMSC as Config;
use SMSFactory\Aware\ClientProviders\CurlTrait;

/**
 * Class SMSC. SMSC Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 */
class SMSC extends Config implements ProviderInterface {

    /**
     * Using Curl client (you can make a change to Stream)
     */
    use CurlTrait;

    /**
     * Recipient of message
     *
     * @var null|int
     */
    private $recipient  =   null;

    /**
     * Server reply message
     *
     * @var string
     */
    private $reply  =   null;

    /**
     * Get provider configurations
     *
     * @throws \Phalcon\Exception
     * @return BulkSMSConfig | array
     */
    public function config() {
        return $this->getProviderConfig();
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return BulkSMS
     */
    public function setRecipient($recipient) {
        $this->recipient    =   $recipient;

        return $this;
    }

    /**
     * Get server response message
     *
     * @see  getReply()->header
     * @see  getReply()->body
     * @return string
     */
    public function getReply() {
        return $this->reply;
    }

    /**
     * Final send function
     *
     * @param string $message
     * @return \Phalcon\Http\Client\Response|string|void
     */
    final public function send($message) {

        $this->reply = $this->client()->{$this->method}($this->url, array_merge(
            $this->config(), [
                'phones'    =>  $this->recipient,   //  SMS Receipient
                'mes'       =>  urlencode($message),           //  Message
            ])
        );

        return ($this->debug === true) ? $this->reply : $this->reply->body;
    }
}
