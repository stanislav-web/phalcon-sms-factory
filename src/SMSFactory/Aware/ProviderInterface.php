<?php
namespace SMSFactory\Aware;

interface ProviderInterface {

    /**
     * Set provider server url
     * (You may reconfigure server url from outer call)
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url);

    /**
     * Set the recipient of the message
     *
     * @param int $recipient
     * @return void
     */
    public function setRecipient(int $recipient);

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