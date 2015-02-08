<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class MessageBird. Configuration for MessageBird provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class MessageBird implements ProviderConfig {

    /**
     * Send message url
     *
     * @const string SEND_MESSAGE_URL
     */
    const SEND_MESSAGE_URL = 'https://rest.messagebird.com/messages';

    /**
     * Get balance url
     *
     * @const string GET_BALANCE_URL
     */
    const GET_BALANCE_URL = 'https://rest.messagebird.com/balance';

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
        '2'   =>  'Request not allowed',
        '9'   =>  'Missing params',
        '10'  =>  'Invalid params',
        '20'  =>  'Not found',
        '25'  =>  'Not enough balance',
        '98'  =>  'API not found',
        '99'  =>  'Internal error',
    ];

    /**
     * Provider config. You may overload this by setter
     *
     * @access static
     * @var array
     */
    private static $config = [
        'originator'        => 'Stanislav',
        'access_key'    =>  'test_UHaeiTLfAe3avOULhawXvn7iR',
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
