<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class BulkSMS. Configuration for BulkSMS provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class BulkSMS implements ProviderConfig {

    /**
     * Send message url
     *
     * @const string SEND_MESSAGE_URL
     */
    const SEND_MESSAGE_URL = 'http://bulksms.vsms.net:5567/eapi/submission/send_sms/2/2.0';

    /**
     * Get balance url
     *
     * @const string GET_BALANCE_URL
     */
    const GET_BALANCE_URL = 'http://bulksms.vsms.net:5567/eapi/user/get_credits/1/1.1';

    /**
     * Request method
     *
     * @const string METHOD
     */
    const METHOD = 'POST';

    /**
     * Acceptable provider statuses
     *
     * @var array $statuses
     */
    public static $statuses    =   [
        0   => 'In progress (a normal message submission, with no error encountered so far).',
        1   => 'Scheduled (see Scheduling below).',
        22  => 'Internal fatal error.',
        23  => 'Authentication failure.',
        24  => 'Data validation failed.',
        25  => 'You do not have sufficient credits.',
        26  => 'Upstream credits not available.',
        27  => 'You have exceeded your daily quota.',
        28  => 'Upstream quota exceeded.',
        40  => 'Temporarily unavailable.',
        201 => 'Maximum batch size exceeded.',
        500 => 'Undefined error.'
    ];

    /**
     * Provider config. You may overload this by setter
     *
     * @access static
     * @var array
     */
    private static $config = [
        'username'  => 'SWEB',
        'password'  => 'QWERTY123',
    ];

    /**
     * Get provider configurations
     *
     * @uses Phalcon\Config
     * @access static
     * @return void
     */
    public static function getProviderConfig() {

        if(empty(self::$config) === false) {
            return (new Config(self::$config))->toArray();
        }
        else {
            throw new Exception('Empty provider config');
        }
    }

    /**
     * Get provider response status
     *
     * @param int $code
     * @access static
     * @return string
     */
    public static function getResponseStatus($code) {

        return  self::$statuses[$code];
    }
}