<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfigInterface;
use Phalcon\Exception;

/**
 * Class Clickatell. Configuration for Clickatell provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class Clickatell implements ProviderConfigInterface
{

    /**
     * Send message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'http://api.clickatell.com/http/sendmsg';

    /**
     * Get balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'http://api.clickatell.com/http/getbalance';

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
        '001' => 'Authentication details are incorrect.',
        '002' => 'Authorization error, unknown user name or incorrect password.',
        '003' => 'The session ID has expired after a pre-set time of inactivity.',
        '005' => 'Missing session ID attribute in request.',
        '007' => 'You have locked down the API instance to a specific IP
address and then sent from an IP address different to the one
you set.',
        '101' => 'One or more required parameters are missing or invalid.',
        '102' => 'The format of the user data header is incorrect.',
        '103' => 'The API message ID is unknown. Log in to your API account to
check the ID or create a new one.',
        '104' => 'The client ID message that you are querying does not exist.',
        '105' => 'The destination address you are attempting to send to is
invalid.',
        '106' => 'The sender address that is specified is incorrect.',
        '107' => 'The message has no content',
        '108' => 'The API message ID is either incorrect or has not been
included in the API call.',
        '109' => 'This can be either a client message ID or API message ID. For
example when using the stop message command.',
        '113' => 'The text message component of the message is greater than
the permitted 160 characters (70 Unicode characters). Select
concat equal to 1,2,3-N to overcome this by splitting the
message across multiple messages.',
        '114' => 'This implies that the gateway is not currently routing messages
to this network prefix. Please email support@clickatell.com with
the mobile number in question.',
        '115' => 'Message has expired before we were able to deliver it to the
upstream gateway. No charge applies.',
        '116' => 'The format of the unicode data entered is incorrect.',
        '120' => 'The format of the delivery time entered is incorrect.',
        '121' => 'This number is not allowed to receive messages from us and
has been put on our block list.',
        '122' => 'The user has opted out and is no longer subscribed to your
service.',
        '123' => 'A sender ID needs to be registered and approved before it can
be successfully used in message sending.',
        '128' => 'This error may be returned when a number has been delisted.',
        '130' => 'This error is returned when an account has exceeded the
maximum number of MT messages which can be sent daily or
monthly. You can send messages again on the date indicated
by the UNIX TIMESTAMP.',
        '201' => 'The batch ID which you have entered for batch messaging is
not valid. ',
        '202' => 'The batch template has not been defined for the batch.',
        '301' => 'Insufficient credits.',
        '901' => 'Please retry.'
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
