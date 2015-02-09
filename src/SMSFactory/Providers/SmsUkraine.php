<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders\CurlTrait;

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
            throw new Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // parse json response
        $isJson = \SMSFactory\Helpers\String::isJson($response->body);

        if ($isJson === true) {
            $respArray = json_decode($response->body, true);
        } else {
            // this is not json response, parse as string
            if (stripos($response->body, 'errors') !== false) {
                // have an error
                preg_match('/^([errors]+):(.*)/', $response->body, $matches);

                // if status exist
                $status = (array_key_exists($matches[0], $this->config->statuses))
                    ? $this->config->getResponseStatus($matches[0])
                    : $matches[2];
            }
        }

        return ($this->debug === true) ? [
            $response, (isset($status) === true) ? $status : $respArray
        ] : (isset($status) === true) ? $status : $respArray;
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
                'command' => 'send',
                'to' => $this->recipient, //  SMS Receipient
                'message' => $message, //  Message
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
        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getBalanceUri(), array_merge(
                $this->config->getProviderConfig(), [
                'command' => 'balance'
            ])
        );

        // return response
        return $this->getResponse($response);
    }
}
