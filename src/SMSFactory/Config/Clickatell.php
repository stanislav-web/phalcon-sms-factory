<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class Clickatell. Configuration for Clickatell provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class Clickatell implements ProviderConfig {

    /**
     * Connect url
     * @var string $url
     */
    protected $url = 'http://api.clickatell.com/http/sendmsg';

    /**
     * Provider config. You may overload this by setter
     * @var array
     */
    private $config = [
        'api_id'    => '3524819',
        'user'      => 'SWEB-TEST',
        'password'  => 'JRdaZcAGbaZSgR',
    ];

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

    /**
     * Set provider settings
     *
     * @return BulkSMS
     */
    public function setProviderConfig(array $config) {

        $this->config = $config;

        return $this;
    }
}
