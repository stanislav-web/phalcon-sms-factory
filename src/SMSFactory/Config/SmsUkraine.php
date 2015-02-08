<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Exception;

/**
 * Class SmsUkraine. Configuration for SmsUkraine provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class SmsUkraine implements ProviderConfig {

    /**
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'http://smsukraine.com.ua/api/http.php';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'http://smsukraine.com.ua/api/json.php';

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
    public $statuses    =   [
        '100'   =>  'The message is scheduled. Delivery has not yet been initiated.',
        '101'   =>  'The message is in enroute state.',
        '102'   =>  'Message is delivered to destination',
        '103'   =>  'Message validity period has expired.',
        '104'   =>  'Message has been deleted.',
        '105'   =>  'Message is undeliverable.',
        '106'   =>  'Message is in accepted state (i.e. has been manually read on behalf of the subscriber by customer service)',
        '107'   =>  'Message is in invalid state The message state is unknown.',
        '108'   =>  'Message is in a rejected state The message has been rejected by a delivery interface.',
        '109'   =>  'Message discarded',
        '110'   =>  'Message in process of transferring to mobile network',
        '200'   =>  'Неизвестная ошибка',
        '201'   =>  'Неправильный ID сообщения',
        '202'   =>  'Неправильный идентификатор отправителя',
        '203'   =>  'Неправильный номер получателя',
        '204'   =>  'Слишком длинное или пустое сообщение',
        '205'   =>  'Пользователь отключен',
        '206'   =>  'Ошибка биллинга',
        '207'   =>  'Превышение лимита выделенных сообщений',
        '208'   =>  'Сообщение с указанным ID уже существует',
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
