<?php

namespace SMSFactory\Aware;

use Phalcon\Http\Client\Provider\Curl;

trait CurlTrait {

    protected $client;

    public function __construct() {

        $this->getClient();
    }

    public function getClient() {
        $this->client = new Curl();
    }
}