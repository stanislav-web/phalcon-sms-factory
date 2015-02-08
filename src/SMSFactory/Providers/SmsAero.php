<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Config\SmsAero as Config;
use SMSFactory\Aware\ClientProviders\CurlTrait;

/**
 * Class SmsAero. SmsAero Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see http://smsaero.ru/api/
 */
class SmsAero extends Config implements ProviderInterface {

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
     * @return \SMSFactory\Config\SmsAero | array
     */
    public function config() {
        return $this->getProviderConfig();
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return SmsAero
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

        // parse json response
        $isJson = \SMSFactory\Helpers\String::isJson($response->body);

        if($isJson === true) {
            $respArray = json_decode($response->body, true);
        }
        else {

            // if status exist
            $status = (array_key_exists($response->body, Config::$statuses))
                ? Config::getResponseStatus($response->body)
                : $response->body;
        }

        return ($this->debug === true) ? [
            $response, (empty($status) === false) ? $status : $respArray
        ] : (empty($status) === false) ? $status : $respArray;
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
                'to'     =>  $this->recipient,   //  SMS Receipient
                'text'   =>  $message,           //  Message
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
        $response = $this->client()->{strtolower(self::METHOD)}(self::GET_BALANCE_URL, $this->config());

        // return response
        return $this->getResponse($response);
    }
}
