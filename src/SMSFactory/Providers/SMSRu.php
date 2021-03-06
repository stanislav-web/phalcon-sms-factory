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
     * @return array|mixed
     * @throws BaseException
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        if ($response->body > 100) {
            $error = $this->config->statuses[$response->body];
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $error);
        }
        return (($this->debug === true) ? [$response->header, $response] :
            (isset($this->config->statuses[$response->body]))
                ? $this->config->statuses[$response->body] : $response->body);
    }

    /**
     * Final send function
     *
     * @param string $message
     * @return \Phalcon\Http\Client\Response|string|void
     */
    final public function send($message)
    {
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getMessageUri(), array_merge(
            $this->config->getProviderConfig(), [
                'to' => $this->recipient,
                'text' => $message,
            ])
        );

        return $this->getResponse($response);
    }

    /**
     * Final check balance function
     *
     * @return \Phalcon\Http\Client\Response|string|void
     * @throws BaseException
     */
    final public function balance()
    {

        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(),
            $this->config->getProviderConfig());

        return $this->getResponse($response);
    }
}
