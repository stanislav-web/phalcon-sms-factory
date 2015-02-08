<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Exception;

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
class SMSC implements ProviderConfig {

    /**
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'https://smsc.ru/sys/send.php';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'https://smsc.ru/sys/balance.php';

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
        '1'   => 'Ошибка в параметрах.',
        '2'   => 'Неверный логин или пароль.',
        '3'   => 'Недостаточно средств на счете Клиента.',
        '4'   => 'IP-адрес временно заблокирован из-за частых ошибок в запросах.',
        '5'   => 'Неверный формат даты.',
        '6'   => 'Сообщение запрещено (по тексту или по имени отправителя).',
        '7'   => 'Неверный формат номера телефона.',
        '8'   => 'Сообщение на указанный номер не может быть доставлено.',
        '9'   => 'Отправка более одного одинакового запроса на передачу SMS-сообщения либо более пяти одинаковых запросов на получение стоимости сообщения в течение минуты.',
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
