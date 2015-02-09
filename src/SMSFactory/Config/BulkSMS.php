<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfigInterface;
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
class BulkSMS implements ProviderConfigInterface
{

    /**
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'http://bulksms.vsms.net:5567/eapi/submission/send_sms/2/2.0';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'http://bulksms.vsms.net:5567/eapi/user/get_credits/1/1.1';

    /**
     * Success HTTP codes responding
     *
     * @var array $httpSuccessCode
     */
    public $httpSuccessCode = [200];

    /**
     * Acceptable provider statuses
     *
     * @var array $statuses
     */
    public $statuses = [
        '0' => 'In progress (a normal message submission, with no error encountered so far).',
        '1' => 'Scheduled (see Scheduling below).',
        '22' => 'Internal fatal error.',
        '23' => 'Authentication failure.',
        '24' => 'Data validation failed.',
        '25' => 'You do not have sufficient credits.',
        '26' => 'Upstream credits not available.',
        '27' => 'You have exceeded your daily quota.',
        '28' => 'Upstream quota exceeded.',
        '40' => 'Temporarily unavailable.',
        '201' => 'Maximum batch size exceeded.',
        '500' => 'Undefined error.'
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
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get message uri
     *
     * @return string
     */
    public function getMessageUri()
    {

        return (isset($this->config['message_uri']) === true) ? $this->config['message_uri']
            : self::SEND_MESSAGE_URI;
    }

    /**
     * Get balance uri
     *
     * @return string
     */
    public function getBalanceUri()
    {

        return (isset($this->config['balance_uri']) === true) ? $this->config['balance_uri']
            : self::GET_BALANCE_URI;
    }

    /**
     * Get provider response method
     *
     * @return string
     */
    public function getRequestMethod()
    {

        return (isset($this->config['request_method']) === true) ? $this->config['request_method']
            : self::REQUEST_METHOD;
    }

    /**
     * Get provider configurations
     *
     * @throws \Phalcon\Exception
     * @return array
     */
    public function getProviderConfig()
    {

        if (empty($this->config) === false) {
            return $this->config;
        } else {
            throw new Exception('Empty provider config');
        }
    }

    /**
     * Get provider response status
     *
     * @param int $code
     * @return string
     */
    public function getResponseStatus($code)
    {

        return (isset($this->statuses[$code]) === true) ? $this->statuses[$code]
            : 'Unknown provider response error';
    }
}