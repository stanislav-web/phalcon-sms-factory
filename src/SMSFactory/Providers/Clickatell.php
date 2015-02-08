<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Config\Clickatell as Config;
use SMSFactory\Aware\ClientProviders\CurlTrait;

/**
 * Class Clickatell. Clickatell Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see https://www.clickatell.com/apis-scripts/scripts/php/
 */
class Clickatell extends Config implements ProviderInterface {

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
     * @return \SMSFactory\Config\Clickatell | array
     */
    public function config() {
        return $this->getProviderConfig();
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return Clickatell
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
        if(stripos($response->body, 'ERR') !== false) {
            // have an error
            preg_match('/(\d{3})/', $response->body, $matches);

            // if status exist
            $status = (array_key_exists($matches[0], Config::$statuses))
                ? Config::getResponseStatus($matches[0])
                : '';
        }

        return ($this->debug === true) ? [
            $response, (empty($status) === false) ? $status : $response->body
        ] : (empty($status) === false) ? $status : $response->body;
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
                'to'     =>  $this->recipient,      //  SMS Recipient
                'text'   =>  $message,   //  Message
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
