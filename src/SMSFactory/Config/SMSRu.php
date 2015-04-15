<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfigInterface;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SMSRu. Configuration for SMSRu provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class SMSRu implements ProviderConfigInterface
{
    /**
     * Message uri
     *
     * @const string SEND_MESSAGE_URI
     */
    const SEND_MESSAGE_URI = 'http://sms.ru/sms/send';

    /**
     * Balance uri
     *
     * @const string GET_BALANCE_URI
     */
    const GET_BALANCE_URI = 'http://sms.ru/my/balance';

    /**
     * Provider config container
     *
     * @access static
     * @var array
     */
    private $config = [];

    /**
     * Acceptable provider statuses
     *
     * @var array $statuses
     */
    public $statuses = [
        '100' => 'Сообщение принято к отправке',
        '200' => 'Неправильный api_id',
        '201' => 'Не хватает средств на лицевом счету',
        '202' => 'Неправильно указан получатель',
        '203' => 'Нет текста сообщения',
        '204' => 'Имя отправителя не согласовано с администрацией',
        '205' => 'Сообщение слишком длинное (превышает 8 СМС)',
        '206' => 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
        '207' => 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
        '208' => 'Параметр time указан неправильно',
        '209' => 'Вы добавили этот номер (или один из номеров) в стоп-лист',
        '210' => 'Используется GET, где необходимо использовать POST',
        '211' => 'Метод не найден',
        '212' => 'Текст сообщения необходимо передать в кодировке UTF-8 (вы передали в другой кодировке)',
        '220' => 'Сервис временно недоступен, попробуйте чуть позже.',
        '230' => 'Сообщение не принято к отправке, так как на один номер в день нельзя отправлять более 60 сообщений.',
        '300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
        '301' => 'Неправильный пароль, либо пользователь не найден',
        '302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)',
    ];

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
     * @throws BaseException
     * @return array
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
