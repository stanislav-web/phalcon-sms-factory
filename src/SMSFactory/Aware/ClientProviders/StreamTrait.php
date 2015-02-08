<?php
namespace SMSFactory\Aware\ClientProviders;

use Phalcon\Http\Client\Provider\Stream;

/**
 * Class StreamTrait. Provide sockets inside app
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware\ClientProviders\StreamTrait
 * @subpackage SMSFactory
 */
trait StreamTrait
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
     * Get stream client
     *
     * @return Stream
     */
    public function client()
    {
        return new Stream();
    }
}