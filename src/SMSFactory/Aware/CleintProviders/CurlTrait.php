<?php
namespace SMSFactory\Aware\ClientProviders\CurlTrait;

use Phalcon\Http\Client\Provider\Curl;

/**
 * Class CurlTrait
 *
 * @package SMSFactory\Aware\ClientProviders\CurlTrait
 * @subpackage SMSFactory
 */
trait CurlTrait {

    /**
     * @var Curl $client
     * @access protected
     */
    protected $client;

    /**
     * Get curl client
     *
     * @return Curl
     */
    public function getClient() {
        $this->client = new Curl();
    }
}