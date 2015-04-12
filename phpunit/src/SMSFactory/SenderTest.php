<?php
namespace Test\SMSFactory;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use SMSFactory\Sender;
use SMSFactory\Exceptions\BaseException;

/**
 * Class SenderTest
 *
 * @package Test\SMSFactory
 * @since   PHP >=5.5.12
 * @version 1.0
 * @author  Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class SenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * DependencyInjector service
     *
     * @var \Phalcon\DI\FactoryDefault
     */
    private $di;

    /**
     * Configuration file
     *
     * @var \Phalcon\Config
     */
    private $config;

    /**
     * Initialize DI
     */
    public function __construct() {
        $this->di = new FactoryDefault();

        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/config.php'
            );
        });
    }

    /**
     * Initialize testing object
     *
     * @uses Searcher
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->config = $this->di->get('config');
    }

    /**
     * Test constructor
     *
     * @covers \SMSFactory\Sender::__construct()
     */
    public function testConstructor()
    {
        new Sender($this->di);
    }

    /**
     * Test exceptions
     *
     * @covers \SMSFactory\Sender::__construct()
     * @expectedException     \SMSFactory\Exceptions\BaseException
     * @expectedExceptionCode 500
     */
    public function testException()
    {
        $this->di->remove('config');
        new Sender($this->di);
    }

    /**
     * Test exceptions
     *
     * @covers \SMSFactory\Sender::__construct()
     * @expectedException     \SMSFactory\Exceptions\BaseException
     * @expectedExceptionCode 500
     */
    public function testCallException()
    {
        $sms = (new Sender($this->di))->call('Undefined');
    }
}


 