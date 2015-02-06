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
interface ProviderInterface {

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return void
     */
    public function setRecipient($recipient);

    /**
     * Send method
     *
     * @param string $message
     * @return void
     */
    public function send($message);

    /**
     * Reply method (after sending)
     *
     * @return string
     */
    public function getReply();
}