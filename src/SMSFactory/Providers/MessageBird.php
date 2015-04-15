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
     * @return array|mixed
     * @throws BaseException
     */
    public function getResponse(\Phalcon\Http\Client\Response $response)
    {
        // parse json response
        $data = json_decode($response->body, true);

        if (isset($data['errors']) === true || $response->header->statusCode > self::MAX_SUCCESS_CODE) {

            $error = $data['errors'][0]['description'];
            throw new BaseException((new \ReflectionClass($this->config))->getShortName(), $error);
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

        $response = $this->client()->{$this->config->getRequestMethod()}($this->config->getMessageUri(), array_merge(
                $this->config->getProviderConfig(), [
                    'recipients' => $this->recipient,
                    'body' => $message,
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
        $client = $this->client();
        $client->setOption(CURLOPT_HTTPHEADER, ['Authorization : '.$this->config->getProviderConfig()['access_key']]);
        $response = $client->{$this->config->getRequestMethod()}($this->config->getBalanceUri(),
            $this->config->getProviderConfig());

        return $this->getResponse($response);
    }
}
