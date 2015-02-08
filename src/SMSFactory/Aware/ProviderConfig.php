<?php
namespace SMSFactory\Aware;

/**
 * Interface ProviderConfig
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware
 * @subpackage SMSFactory
 */
interface ProviderConfig {

    /**
     * Default request method
     * @const REQUEST_METHOD
     */
    const REQUEST_METHOD = 'POST';

    /**
     * Get request method
     *
     * @return void
     */
    public function getRequestMethod();

    /**
     * Get message uri
     *
     * @return void
     */
    public function getMessageUri();

    /**
     * Get balance uri
     *
     * @return void
     */
    public function getBalanceUri();

    /**
     * Get provider configurations
     *
     * @return void
     */
    public function getProviderConfig();

    /**
     * Get provider response status
     *
     * @param int $status
     * @return void
     */
    public function getResponseStatus($status);
}