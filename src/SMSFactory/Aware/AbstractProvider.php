<?php
namespace SMSFactory\Aware;

/**
 * Class AbstractProvider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware
 * @subpackage SMSFactory
 */
abstract class AbstractProvider
{

    /**
     * Global app config container
     *
     * @var \Phalcon\Config $config
     */
    protected $config;

    /**
     * Call provider interface
     *
     * @param $provider
     * @return mixed
     */
    abstract protected function call($provider);
}