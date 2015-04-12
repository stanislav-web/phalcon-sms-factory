<?php
namespace Test\SMSFactory;

use SMSFactory\Sender;

use \Phalcon\DI\FactoryDefault;

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
     * Sender class object
     *
     * @var \SMSFactory\Sender
     */
    private $sender;

    /**
     * Initialize DI
     */
    public function __construct() {
        $this->di = new FactoryDefault();

        $this->di->set('config', function() {

        });
    }


    /**
     * Initialize testing object
     *
     * @uses \SMSFactory\Sender
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->sender = new Sender(new Di());
    }

    /**
     * Kill testing object
     *
     * @uses Builder
     */
    public function tearDown()
    {
        $this->builder = null;
    }

    /**
     * @covers Searcher\Builder::__construct()
     */
    public function testConstructor()
    {

    }
}


 