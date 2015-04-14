<?php
namespace SMSFactory\Providers;

use SMSFactory\Exceptions\BaseException;
use SMSFactory\Aware\ProviderInterface;
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
class Clickatell implements ProviderInterface
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
     * @var \SMSFactory\Config\Clickatell $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\Clickatell $config
     */
    public function __construct(\SMSFactory\Config\Clickatell $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return Clickatell
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
     * @return array|mixed|\Phalcon\Http\Client\Response
     * @throws BaseException
     * @throws \Exception
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // check response status
        if ($response->header->statusCode > self::MAX_SUCCESS_CODE) {
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), 'The server is not responding: ' . $response->header->statusMessage);
        }

        // get server response status
        if (stripos($response->body, 'ERR') !== false) {

            // have an error
            preg_match('/([\d]{3}).\s([a-z\s]+)$/i', $response->body, $matches);

            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $matches[2]);
        }

        return ($this->debug === true) ? [$response->header, $response] : $response->body;
    }

    /**
     * Final send function
     *
     * @param string $message
     * @return string
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
     * @return string
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
