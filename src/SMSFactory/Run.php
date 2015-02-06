<?php
namespace SMSFactory;
use Phalcon\Exception;
use SMSFactory\Aware\Provider;

class Run extends Provider {

    /**
     * Get SMS provider
     *
     * @param string $providerName demanded provider
     *
     * @uses    ProviderInterface::setRecipient()
     * @uses    ProviderInterface::setMessage()
     * @uses    ProviderInterface::send()
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