<?php
namespace SMSFactory\Aware;

interface ProviderConfig {

    /**
     * Get provider settings
     *
     * @uses Phalcon\Config
     * @return void
     */
    public function get();
}