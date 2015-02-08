<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
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
     * Send message url
     *
     * @const string SEND_MESSAGE_URL
     */
    const SEND_MESSAGE_URL = 'http://smsukraine.com.ua/api/http.php';

    /**
     * Get balance url
     *
     * @const string GET_BALANCE_URL
     */
    const GET_BALANCE_URL = 'http://smsukraine.com.ua/api/json.php';

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
     * Provider config. You may overload this by setter
     *
     * @access static
     * @var array
     */
    private static $config = [
        'from'        => 'SWEB',
        'login'     => '380954916517',
        'password'  => '1111111111',
        'version'  => 'http',
        'flash'     => 0,
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
