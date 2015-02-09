<?php
namespace SMSFactory\Providers;

use Phalcon\Http\Response\Exception;
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
     * @throws \Phalcon\Http\Response\Exception
     * @return string
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {

        // check response status
        if (in_array($response->header->statusCode, $this->config->httpSuccessCode) === false) {
            throw new Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // get server response status
        if (stripos($response->body, 'ERR') !== false) {
            // have an error
            preg_match('/(\d{3})/', $response->body, $matches);

            // if status exist
            $status = (array_key_exists($matches[0], $this->config->statuses))
                ? $this->config->getResponseStatus($matches[0])
                : '';
        }

        return ($this->debug === true) ? [
            $response, (isset($status) === true) ? $status : $response->body
        ] : (isset($status) === true) ? $status : $response->body;
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
                'to' => $this->recipient, //  SMS Recipient
                'text' => $message, //  Message
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
