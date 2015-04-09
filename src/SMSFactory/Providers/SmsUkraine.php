<?php
namespace SMSFactory\Providers;

use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders\CurlTrait;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SmsUkraine. SmsUkraine Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see http://smsukraine.com.ua/techdocs/
 */
class SmsUkraine implements ProviderInterface
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
     * @var \SMSFactory\Config\SmsUkraine $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\SmsUkraine $config
     */
    public function __construct(\SMSFactory\Config\SmsUkraine $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return SmsUkraine
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
     * @throws \Phalcon\Http\Response\Exception
     * @return array|string
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {

        // check response status
        if (in_array($response->header->statusCode, $this->config->httpSuccessCode) === false) {
            throw new \Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // this is not json response, parse as string
        if (stripos($response->body, 'errors') !== false) {
            // have an error
            preg_match_all('/errors:([\w].*)/iu', $response->body, $matches);
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), implode('.', $matches[0]));
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
                'command' => 'send',
                'to' => $this->recipient,   //  SMS Receipient
                'message' => $message,           //  Message
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
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(), array_merge(
                $this->config->getProviderConfig(), [
                'command' => 'balance'
            ])
        );

        // return response
        return $this->getResponse($response);
    }
}
