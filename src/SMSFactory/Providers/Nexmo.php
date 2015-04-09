<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders\CurlTrait;
use SMSFactory\Exceptions\BaseException;

/**
 * Class Nexmo. Nexmo Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see https://docs.nexmo.com/index.php/sms-api
 */
class Nexmo implements ProviderInterface
{

    /**
     * Using Curl client (you can make a change to Stream)
     */
    use CurlTrait;

    /**
     * Recipient of message
     *
     * @var null|int
     */
    private $recipient = null;

    /**
     * Provider config object
     *
     * @var \SMSFactory\Config\Nexmo $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\Nexmo $config
     */
    public function __construct(\SMSFactory\Config\Nexmo $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return Nexmo
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get server response info
     *
     * @param \Phalcon\Http\Client\Response $response
     * @throws \Exception
     * @return array|string
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // check response status
        if (in_array($response->header->statusCode, $this->config->httpSuccessCode) === false) {
            throw new \Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // parse json response

        $response = json_decode($response->body, true);

        foreach($response['messages'] as $message) {
            if(isset($message['error-text'])) {
                throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $message['error-text']);
            }
        }

        return ($this->debug === true) ? [$response->header, $response] : $response;
    }

    /**
     * Final send function
     *
     * @param string $message
     * @return \Phalcon\Http\Client\Response|string|void
     */
    final public function send($message)
    {

        // send message
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getMessageUri(), array_merge(
                $this->config->getProviderConfig(), [
                'to' => $this->recipient,      //  SMS Recipient
                'text' => $message,   //  Message
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
    final public function balance()
    {

        // check balance
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(),
            $this->config->getProviderConfig());

        // return response
        return $this->getResponse($response);
    }
}
