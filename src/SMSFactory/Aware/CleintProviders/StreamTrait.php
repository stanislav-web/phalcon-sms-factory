<?php
namespace SMSFactory\Aware\ClientProviders\StreamClient;

use Phalcon\Http\Client\Provider\Stream;

/**
 * Class StreamTrait
 *
 * @package SMSFactory\Aware\ClientProviders\StreamTrait
 * @subpackage SMSFactory
 */
trait StreamTrait {

    /**
     * @var Stream $client
     * @access protected
     */
    protected $client;

    /**
     * Get stream client
     *
     * @return Stream
     */
    public function getClient() {
        $this->client = new Stream();
    }
}