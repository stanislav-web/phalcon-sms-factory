<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Config\BulkSMS as Config;
use SMSFactory\Aware\ClientProviders\CurlTrait;

/**
 * Class BulkSMS. BulkSMS Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see	 http://www.bulksms.com/int/docs/
 */
class BulkSMS extends Config implements ProviderInterface {

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
     * Get provider configurations
     *
     * @throws \Phalcon\Exception
     * @return \SMSFactory\Config\BulkSMS | array
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
     * Get server response info
     *
     * @param \Phalcon\Http\Client\Response $response
     * @throws \Phalcon\Http\Response\Exception
     * @return array|string
     */
    public function getResponse(\Phalcon\Http\Client\Response $response) {

        // check response status

        if($response->header->statusCode !== self::SUCCESS_CODE) {
            throw new Exception('The server is not responding.');
        }

        // get server response status
        $part = explode('|', $response->body);

        // if status exist. If response is 0 - that meant OK
        $status = (array_key_exists($part[0], Config::$statuses) && $part[0] > 0)
            ? Config::getResponseStatus($part[0])
            : $part[1];

        return ($this->debug === true) ? [
            $response,$status
        ] : $status;
    }

    /**
     * Final send function
     *
     * @param string $message
     * @return \Phalcon\Http\Client\Response|string|void
     */
    final public function send($message) {

        // send message
        $response = $this->client()->{self::METHOD}(self::SEND_MESSAGE_URL, array_merge(
            $this->config(), [
                'msisdn'    =>  $this->recipient,       //  SMS Recipient
                'message'   =>  $message,    //  Message
            ])
        );

        // return response
        return $this->getResponse($response);
    }

    /**
     * Final check balance function
     *
     * @throws \Phalcon\Http\Response\Exception
     * @return \Phalcon\Http\Client\Response|string|void
     */
    final public function balance() {

        // check balance
        $response = $this->client()->{strtolower(self::METHOD)}(self::GET_BALANCE_URL,  $this->config());

        // return response
        return $this->getResponse($response);
    }
}
