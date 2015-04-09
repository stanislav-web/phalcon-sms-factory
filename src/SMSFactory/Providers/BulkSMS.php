<?php
namespace SMSFactory\Providers;

use SMSFactory\Exceptions\BaseException;
use SMSFactory\Aware\ProviderInterface;
use SMSFactory\Aware\ClientProviders\CurlTrait;

/**
 * Class BulkSMS. BulkSMS Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Providers
 * @subpackage SMSFactory
 * @see     http://www.bulksms.com/int/docs/
 */
class BulkSMS implements ProviderInterface
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
     * @var \SMSFactory\Config\BulkSMS $config
     */
    private $config;

    /**
     * Init configuration
     *
     * @param \SMSFactory\Config\BulkSMS $config
     */
    public function __construct(\SMSFactory\Config\BulkSMS $config)
    {

        $this->config = $config;
    }

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return BulkSMS
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
        if (in_array($response->header->statusCode, $this->config->httpSuccessCode) === false) {
            throw new \Exception('The server is not responding: ' . $response->header->statusMessage);
        }

        // get server response status
        $part = explode('|', $response->body);

        if($part[0] > 1) {
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $part[1]);
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
                'msisdn' => $this->recipient,       //  SMS Recipient
                'message' => $message,    //  Message
            ])
        );

        // return response
        return $this->getResponse($response);
    }

    /**
     * Final check balance function
     *
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
