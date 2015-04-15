<?php
namespace SMSFactory;

use SMSFactory\Aware\Provider;
use SMSFactory\Exceptions\BaseException;

/**
 * Class Sender. App entry point
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory
 * @subpackage SMSFactory
 */
class Sender extends Provider
{

    /**
     * Inject of Phalcon dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @throws BaseException
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di)
    {
        if ($di->has('config') === true) {
            $this->config = $di->get('config')->sms->toArray();
        } else {
            throw new BaseException('SMS', 'Please setup your configuration to $di', 500);
        }
    }

    /**
     * Get SMS provider
     *
     * @param string $providerName demanded provider
     *
     * @uses    ProviderInterface::setRecipient()
     * @uses    ProviderInterface::send()
     * @uses    ProviderInterface::balance()
     *
     * @throws BaseException
     * @return mixed
     */
    final public function call($providerName)
    {

        $configProviderClass = "SMSFactory\\Config\\$providerName"; // note: no leading backslash
        $providerClass = "SMSFactory\\Providers\\$providerName"; // note: no leading backslash

        if (class_exists($providerClass) === true) {

            // inject configurations
            return new $providerClass(new $configProviderClass($this->config[$providerName]));
        } else {
            throw new BaseException('SMS', 'Provider ' . $providerName . ' does not exist', 500);
        }
    }

} 