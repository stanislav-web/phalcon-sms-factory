<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

class BulkSMS implements ProviderConfig {

    /**
     * Provider config. You may overload this by setter
     * @var array
     */
    private $config = [
        'url'       => 'http://bulksms.vsms.net:5567/eapi/submission/send_sms/2/2.0',
        'username'  => 'SWEB',
        'password'  => 'QWERTY123',
    ];

    /**
     * Get provider settings
     *
     * @uses Phalcon\Config
     * @return void
     */
    public function get() {

        if(empty($this->config) === false) {
            return new Config($this->config);
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
    public function set(array $config) {

        $this->config = $config;

        return $this;
    }
}
