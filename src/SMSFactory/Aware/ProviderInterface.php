<?php
namespace SMSFactory\Aware;

interface ProviderInterface {

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return void
     */
    public function setRecipient($recipient);

    /**
     * Set message
     *
     * @param string $message
     * @return void
     */
    public function setMessage($message);

    /**
     * Final send function
     *
     * @param array $params additional parameters
     * @return void
     */
    public function send(array $params = []);
}