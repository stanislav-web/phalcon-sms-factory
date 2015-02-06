<?php
namespace SMSFactory\Aware;

use SMSFactory\Providers;

/**
 * Class Provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware
 * @subpackage SMSFactory
 */
abstract class Provider {

    /**
     * Call provider interface
     *
     * @param $provider
     * @return mixed
     */
    abstract protected function call($provider);
}