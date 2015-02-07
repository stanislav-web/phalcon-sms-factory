<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class BulkSMS. Configuration for BulkSMS provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class BulkSMS implements ProviderConfig {

    /**
     * Connect url
     * @var string $url
     */
    protected $url = 'http://bulksms.vsms.net:5567/eapi/submission/send_sms/2/2.0';

    /**
     * Provider config. You may overload this by setter
     * @var array
     */
    private $config = [
        'username'  => 'SWEB',
        'password'  => '11111111',
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
}
