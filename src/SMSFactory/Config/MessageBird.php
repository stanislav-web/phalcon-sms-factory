<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
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
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'https://rest.messagebird.com/messages';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'https://rest.messagebird.com/balance';

    /**
     * Success HTTP codes responding
     *
     * @var array $httpSuccessCode
     */
    public $httpSuccessCode = [200,201,422];

    /**
     * Acceptable provider statuses
     *
     * @var array $statuses
     */
    public $statuses    =   [
        '2'   =>  'Request not allowed',
        '9'   =>  'Missing params',
        '10'  =>  'Invalid params',
        '20'  =>  'Not found',
        '25'  =>  'Not enough balance',
        '98'  =>  'API not found',
        '99'  =>  'Internal error',
    ];

    /**
     * Provider config container
     *
     * @access static
     * @var array
     */
    private $config = [];

    /**
     * Setup injected configuration
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config) {

        $this->config   =   $config;
    }

    /**
     * Get message uri
     *
     * @return string
     */
    public function getMessageUri() {

        return (isset($this->config['message_uri']) === true) ? $this->config['message_uri']
            : self::SEND_MESSAGE_URI;
    }

    /**
     * Get balance uri
     *
     * @return string
     */
    public function getBalanceUri() {

        return (isset($this->config['balance_uri']) === true) ? $this->config['balance_uri']
            : self::GET_BALANCE_URI;
    }

    /**
     * Get provider response method
     *
     * @return string
     */
    public function getRequestMethod() {

        return (isset($this->config['request_method']) === true) ? $this->config['request_method']
            : self::REQUEST_METHOD;
    }

    /**
     * Get provider configurations
     *
     * @return void
     */
    public function getProviderConfig() {

        if(empty($this->config) === false) {
            return $this->config;
        }
        else {
            throw new Exception('Empty provider config');
        }
    }

    /**
     * Get provider response status
     *
     * @param int $code
     * @return string
     */
    public function getResponseStatus($code) {

        return  (isset($this->statuses[$code]) === true) ? $this->statuses[$code]
            : 'Unknown provider response error';
    }
}
