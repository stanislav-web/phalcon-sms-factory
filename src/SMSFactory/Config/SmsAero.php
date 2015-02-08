<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class SmsAero. Configuration for SmsAero provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class SmsAero implements ProviderConfig {

    /**
     * Send message url
     *
     * @const string SEND_MESSAGE_URL
     */
    const SEND_MESSAGE_URL = 'http://gate.smsaero.ru/send';

    /**
     * Get balance url
     *
     * @const string GET_BALANCE_URL
     */
    const GET_BALANCE_URL = 'http://gate.smsaero.ru/balance/?answer=json';

    /**
     * Request method
     *
     * @const string METHOD
     */
    const METHOD = 'GET';

    /**
     * Acceptable provider statuses
     *
     * @var array $statuses
     */
    public static $statuses    =   [
        'accepted'   =>  'Сообщение принято сервисом.',
        'empty field. reject'   =>  'Не все обязательные поля заполнены.',
        'incorrect user or password. reject'   =>  'Ошибка авторизации',
        'no credits'   =>  'Недостаточно sms на балансе.',
        'incorrect sender name. reject'   =>  'Неверная (незарегистрированная) подпись отправителя.',
        'incorrect destination adress. reject'   =>  'Неверно задан номер телефона (формат 71234567890).',
        'incorrect date. reject'   =>  'Неправильный формат даты',
        'in blacklist. reject'   =>  'Телефон находится в черном списке.',
    ];

    /**
     * Provider config. You may overload this by setter
     *
     * @access static
     * @var array
     */
    private static $config = [
        'from'          => 'INFORM',
        'user'          => 'stanisov@gmail.com',
        'password'      => '96e79218965eb72c92a549dd5a330112',
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
