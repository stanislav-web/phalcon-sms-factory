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
     * Get provider configurations
     *
     * @uses Phalcon\Config
     * @access static
     * @return void
     */
    public static function getProviderConfig();

    /**
     * Get provider response status
     *
     * @param int $status
     * @access static
     * @return void
     */
    public static function getResponseStatus($status);
}