<?php
namespace SMSFactory;
use SMSFactory\Aware\ProviderFactory;

class Run extends Provider {

    /**
     * Get SMS provider
     *
     * @param string $provider demanded provider
     *
     * @uses    ProviderInterface::setUrl()
     * @uses    ProviderInterface::setRecipient()
     * @uses    ProviderInterface::setMessage()
     * @uses    ProviderInterface::send()
     *
     * @return boolean|void
     */
    final public function call($provider) {

        return class_exists($provider) === true ? new $provider : 'Fuck';
    }
} 