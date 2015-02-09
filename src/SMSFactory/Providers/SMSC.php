<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
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
 * @see http://smsc.ru/api/code/
 */
class SMSC implements ProviderInterface
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
     * @var \SMSFactory\Config\SMSC $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\SMSC $config
     */
    public function __construct(\SMSFactory\Config\SMSC $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return SMSC
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
            throw new Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // parse json response
        $respArray = json_decode($response->body, true);
        $status = null;

        if (isset($respArray['error_code']) === true) {

            // if status exist.
            $status = (array_key_exists($respArray['error_code'], $this->config->$statuses))
                ? $this->config->getResponseStatus($respArray['error_code'])
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
     * @return array|string
     */
    final public function send($message)
    {

        // send message
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getMessageUri(), array_merge(
                $this->config->getProviderConfig(), [
                'phones' => $this->recipient, //  SMS Receipient
                'mes' => $message, //  Message
            ])
        );

        // return response
        return $this->getResponse($response);
    }

    /**
     * Final check balance function
     *
     * @return array|string
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
