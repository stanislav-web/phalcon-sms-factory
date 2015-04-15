<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfigInterface;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SMSC. Configuration for SMSC provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class SMSC implements ProviderConfigInterface
{

    /**
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'https://smsc.ru/sys/send.php?fmt=3';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'https://smsc.ru/sys/balance.php?fmt=3';

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
     * @throws BaseException
     * @return void
     */
    public function getProviderConfig()
    {

        if (empty($this->config) === false) {
            return $this->config;
        } else {

            throw new BaseException((new \ReflectionClass(get_class()))->getShortName(), 'Empty provider config', 500);
        }
    }
}
