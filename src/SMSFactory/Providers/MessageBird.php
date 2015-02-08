<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Config\MessageBird as Config;
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
 * @see https://www.messagebird.com/en/developers
 */
class MessageBird extends Config implements ProviderInterface {

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
     * Overload success codes from ProviderInterface
     *
     * @see ProviderInterface
     * @var array $httpsuccess
     */
    private $httpsuccess  =   [200,201,422];

    /**
     * Get provider configurations
     *
     * @throws \Phalcon\Exception
     * @return \SMSFactory\Config\MessageBird | array
     */
    public function config() {
        return $this->getProviderConfig();
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return MessageBird
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

        if(in_array($response->header->statusCode, $this->httpsuccess) === false) {
            throw new Exception('The server is not responding.');
        }

        // parse json response
        $respArray = json_decode($response->body, true);
        $status =   null;

        if(isset($respArray['errors']) === true) {

            // if status exist.
            $status = (array_key_exists($respArray['errors'][0]['code'], Config::$statuses))
                ? Config::getResponseStatus($respArray['errors'][0]['code']).' '.$respArray['errors'][0]['description']
                : '';
        }

        return ($this->debug === true) ? [
            $response, ($status === null ? $respArray : $status)
        ] : ($status === null ? $respArray : $status);
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
                'recipients'     =>  $this->recipient,      //  SMS Recipient
                'body'           =>  $message,   //  Message
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
