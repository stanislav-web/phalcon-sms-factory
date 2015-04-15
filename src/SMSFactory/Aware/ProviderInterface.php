<?php
namespace SMSFactory\Aware;

/**
 * Interface ProviderInterface
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware
 * @subpackage SMSFactory
 */
interface ProviderInterface
{

    /**
     * Max success code response
     */
    const MAX_SUCCESS_CODE = 304;

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return void
     */
    public function setRecipient($recipient);

    /**
     * Server response method
     *
     * @param \Phalcon\Http\Client\Response $response
     * @return mixed
     */
    public function getResponse(\Phalcon\Http\Client\Response $response);

    /**
     * Send method
     *
     * @param string $message
     * @return void
     */
    public function send($message);

    /**
     * Check balance function
     *
     * @return void
     */
    public function balance();
}