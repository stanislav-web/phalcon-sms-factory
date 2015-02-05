<?php
namespace SMSFactory\Aware;

use SMSFactory\Providers;

abstract class Provider {

    /**
     * Call provider interface
     *
     * @param $provider
     * @return mixed
     */
    abstract protected function call($provider);
}