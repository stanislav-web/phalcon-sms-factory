<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfigInterface;
use Phalcon\Exception;

/**
 * Class Nexmo. Configuration for Nexmo provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class Nexmo implements ProviderConfigInterface
{

    /**
     * Send message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'https://rest.nexmo.com/sms/json';

    /**
     * Get balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'http://rest.nexmo.com/account/get-balance';

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
        '0' => 'The message was successfully accepted for delivery by Nexmo',
        '1' => 'You have exceeded the submission capacity allowed on this account, please back-off and retry',
        '2' => 'Your request is incomplete and missing some mandatory parameters',
        '3' => 'The value of one or more parameters is invalid',
        '4' => 'The api_key / api_secret you supplied is either invalid or disabled',
        '5' => 'An error has occurred in the Nexmo platform whilst processing this message',
        '6' => 'The Nexmo platform was unable to process this message, for example, an un-recognized number prefix or the number is not whitelisted if your account is new',
        '7' => 'The number you are trying to submit to is blacklisted and may not receive messages',
        '8' => 'The api_key you supplied is for an account that has been barred from submitting messages',
        '9' => 'Your pre-pay account does not have sufficient credit to process this message',
        '11' => 'This account is not provisioned for REST submission, you should use SMPP instead',
        '12' => 'Applies to Binary submissions, where the length of the UDH and the message body combined exceed 140 octets',
        '13' => 'Message was not submitted because there was a communication failure',
        '14' => 'Message was not submitted due to a verification failure in the submitted signature',
        '15' => 'The sender address (from parameter) was not allowed for this message. Restrictions may apply depending on the destination see our FAQs',
        '16' => 'The ttl parameter values is invalid',
        '19' => 'Your request makes use of a facility that is not enabled on your account',
        '20' => 'The message class value supplied was out of range (0 - 3)',
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
