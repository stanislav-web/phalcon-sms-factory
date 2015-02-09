<?php
namespace SMSFactory;

use Phalcon\Exception;
use Phalcon\Config\Exception as ConfigException;
use SMSFactory\Aware\Provider;

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
     * inject of Phalcon dependency container
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di)
    {

        // get configuration service
        if ($di->has('config') === true) {
            $this->config = $di->get('config')->sms->toArray();
        } else {
            throw new ConfigException('Please setup your configuration to $di');
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
     * @throws \Phalcon\Exception
     * @return object $providerClass
     */
    final public function call($providerName)
    {

        $configProviderClass = "SMSFactory\\Config\\$providerName"; // note: no leading backslash
        $providerClass = "SMSFactory\\Providers\\$providerName"; // note: no leading backslash

        if (class_exists($providerClass) === true) {

            // inject configurations
            return new $providerClass(new $configProviderClass($this->config[$providerName]));

        } else {
            throw new Exception('Provider ' . $providerName . ' does not exist');

        }
    }
}