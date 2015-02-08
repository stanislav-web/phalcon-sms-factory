<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
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
     * Send message url
     *
     * @const string SEND_MESSAGE_URL
     */
    const SEND_MESSAGE_URL = 'https://smsc.ru/sys/send.php';

    /**
     * Get balance url
     *
     * @const string GET_BALANCE_URL
     */
    const GET_BALANCE_URL = 'https://smsc.ru/sys/balance.php';

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
        1   => 'Ошибка в параметрах.',
        2   => 'Неверный логин или пароль.',
        3   => 'Недостаточно средств на счете Клиента.',
        4   => 'IP-адрес временно заблокирован из-за частых ошибок в запросах.',
        5   => 'Неверный формат даты.',
        6   => 'Сообщение запрещено (по тексту или по имени отправителя).',
        7   => 'Неверный формат номера телефона.',
        8   => 'Сообщение на указанный номер не может быть доставлено.',
        9   => 'Отправка более одного одинакового запроса на передачу SMS-сообщения либо более пяти одинаковых запросов на получение стоимости сообщения в течение минуты.',
    ];

    /**
     * Provider config. You may overload this by setter
     *
     * @access static
     * @var array
     */
    private static $config = [
        'login'     => 'SWEB',
        'psw'       => '11111111',
        'charset'   => 'utf-8',
        'sender'    => 'Stanislav',
        'translit'  => 0,
        'fmt'       => 3, // response as json
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
