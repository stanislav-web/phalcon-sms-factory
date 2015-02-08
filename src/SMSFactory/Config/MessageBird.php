<?php
namespace SMSFactory\Config;

use SMSFactory\Aware\ProviderConfig;
use Phalcon\Config;
use Phalcon\Exception;

/**
 * Class SMSC. Configuration for SMSC provider
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Config
 * @subpackage SMSFactory
 */
class SMSC implements ProviderConfig {

    /**
     * Connect url
     * @var string $url
     */
    protected $url = 'https://smsc.ru/sys/send.php';

    /**
     * Provider config. You may overload this by setter
     * @var array
     */
    private $config = [
        'login'     => 'SWEB',
        'psw'       => '222222222',
        'charset'   => 'utf-8',
        'sender'    => 'Stanislav'
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
