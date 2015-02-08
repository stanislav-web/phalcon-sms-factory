<?php
namespace SMSFactory;

use Phalcon\Exception;
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
class Sender extends Provider {

    /**
     * Get SMS provider
     *
     * @param string $providerName demanded provider
     *
     * @uses    ProviderInterface::setRecipient()
     * @uses    ProviderInterface::setMessage()
     * @uses    ProviderInterface::send()
     * @uses    ProviderInterface::balance()
     *
     * @throws \Phalcon\Exception
     * @return mixed
     */
    final public function call($providerName)
    {

        $providerClass = "SMSFactory\\Providers\\$providerName"; // note: no leading backslash

        if(class_exists($providerClass) === true) {
            return new $providerClass;
        }
        else {
            throw new Exception('Provider ' . $providerName . ' does not exist');
        }
    }

} 