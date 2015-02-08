<?php
namespace SMSFactory\Aware\ClientProviders;

use Phalcon\Http\Client\Provider\Curl;

/**
 * Class CurlTrait. Provide libcurl inside app
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware\ClientProviders\CurlTrait
 * @subpackage SMSFactory
 */
trait CurlTrait
{

    /**
     * @var boolean $debug
     * @access protected
     */
    protected $debug = false;

    /**
     * Setup debug
     *
     * @param boolean $flag
     * @return Stream
     */
    public function debug($flag)
    {
        $this->debug = (in_array($flag, [true, false])) ? $flag : false;

        return $this;
    }

    /**
     * Get curl client
     *
     * @access public
     * @return Curl
     */
    public function client()
    {
        return new Curl();
    }
}