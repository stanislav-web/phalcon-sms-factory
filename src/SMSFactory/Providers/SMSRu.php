<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders\CurlTrait;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SMSRu. SMSRu Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see http://smsc.ru/api/code/
 */
class SMSRu implements ProviderInterface
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
     * @var \SMSFactory\Config\SMSRu $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\SMSRu $config
     */
    public function __construct(\SMSFactory\Config\SMSRu $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return SMSRu
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
     * @return array|string
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // check response status
        if (in_array($response->header->statusCode, $this->config->httpSuccessCode) === false) {
            throw new \Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        if($response->body > 100) {

            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $this->config->statuses[$response->body]);
        }

        return ($this->debug === true) ? [$response->header, $response] : $this->config->statuses[$response->body];
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
                'to' => $this->recipient,       //  SMS Receipient
                'text' => $message,             //  Message
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
