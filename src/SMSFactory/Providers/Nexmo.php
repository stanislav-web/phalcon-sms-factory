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
     * @return array|mixed
     * @throws BaseException
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // parse json response

        $response = json_decode($response->body, true);

        if (isset($response['messages'][0]['error-text']) === true) {
            $error = $response['messages'][0]['error-text'];
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $error);
        }

        if (isset($response['error-code']) === true) {
            $error = $response['error-code-label'];
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $error);
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

        // check balance
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(),
            $this->config->getProviderConfig());

        // return response
        return $this->getResponse($response);
    }
}
