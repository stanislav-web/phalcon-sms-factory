<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class Nexmo. Configuration for Nexmo provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class Nexmo implements ProviderConfig {

    /**
     * Connect url
     * @var string $url
     */
    protected $url = 'https://rest.nexmo.com/sms/json';

    /**
     * Provider config. You may overload this by setter
     * @var array
     */
    private $config = [
        'from'      => 'SWEB',
        'api_key'       => '90c8f84f',
        'api_secret'  => '1111111',
        'type'      => 'unicode'
    ];

    /**
     * Request method
     *
     * @var string
     */
    protected $method = 'post';

    /**
     * Get provider settings
     *
     * @uses Phalcon\Config
     * @return void
     */
    public function getProviderConfig() {

        if(empty($this->config) === false) {
            return (new Config($this->config))->toArray();
        }
        else {
            throw new Exception('Empty provider config');
        }
    }
}
