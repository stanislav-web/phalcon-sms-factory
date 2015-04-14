<?php
namespace SMSFactory\Providers;

use SMSFactory\Exceptions\BaseException;
use SMSFactory\Aware\ProviderInterface;
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
class MessageBird implements ProviderInterface
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
     * @var \SMSFactory\Config\MessageBird $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\MessageBird $config
     */
    public function __construct(\SMSFactory\Config\MessageBird $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return MessageBird
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
        if ($response->header->statusCode > self::MAX_SUCCESS_CODE) {
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), 'The server is not responding: ' . $response->header->statusMessage);
        }

        // parse json response
        $data = json_decode($response->body, true);

        if (isset($data['errors']) === true) {

            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $data['errors'][0]['description']);
        }

        return ($this->debug === true) ? [$response->header, $data] : $data;
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
                'recipients' => $this->recipient,      //  SMS Recipient
                'body' => $message,   //  Message
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
