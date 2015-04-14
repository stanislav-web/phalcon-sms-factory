<?php
namespace Test\SMSFactory;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use SMSFactory\Sender;

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
     * Recipient test phone number
     *
     * @var int $phone
     */
    private $phone = 380990000000;

    /**
     * Message
     *
     * @var string $message
     */
    private $message = 'PHPUnit Send tester';

    /**
     * DependencyInjector service
     *
     * @var \Phalcon\DI\FactoryDefault $di
     */
    private $di;

    /**
     * Configuration file
     *
     * @var \Reflection
     */
    private $reflection;

    /**
     * Initialize testing object
     *
     * @uses Searcher
     * @uses \ReflectionClass
     */
    public function setUp()
    {
        $this->di = new FactoryDefault();
        $this->reflection = new \ReflectionClass('\SMSFactory\Sender');
    }

    /**
     * Get SMS Providers
     *
     * @return array
     */
    public function additionDataProvider()
    {
        $data = [];
        $providers = array_keys((new Config(
            require './phpunit/data/config.php'
        ))->sms->toArray());

        foreach($providers as $provider) {
            $data[] = array($provider);
        }
        return $data;
    }

    /**
     * Get SMS Providers with error data
     *
     * @return array
     */
    public function additionErrorsDataProvider()
    {
        $data = [];
        $providers = array_keys((new Config(
            require './phpunit/data/error.php'
        ))->sms->toArray());

        foreach($providers as $provider) {
            $data[] = array($provider);
        }
        return $data;
    }

    /**
     * Test constructor
     *
     * @covers \SMSFactory\Sender::__construct()
     */
    public function testConstructor()
    {

        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/config.php'
            );
        });

        $sender = new Sender($this->di);

        $this->assertInstanceOf('SMSFactory\Sender', $sender, "[-] Provider instance error");

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
     * @covers SMSFactory\Sender::call
     * @expectedException     \SMSFactory\Exceptions\BaseException
     * @expectedExceptionCode 500
     */
    public function testCallException()
    {
        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/error.php'
            );
        });

        (new Sender($this->di))->call('Undefined');
    }

    /**
     * @dataProvider additionDataProvider
     * @covers SMSFactory\Sender::call
     * @covers SMSFactory\Sender<extended>
     */
    public function testCall($provider)
    {
        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/config.php'
            );
        });

        // check modifier before run
        $modifiers = (new \ReflectionMethod('SMSFactory\Sender', 'call'))->getModifiers();
        $this->assertEquals(['final', 'public'], \Reflection::getModifierNames($modifiers),
            "[-] call method must be as final public"
        );

        $providerClass = "SMSFactory\\Providers\\$provider";

        $this->assertEquals(true, class_exists($providerClass), "[-] Provider ".$providerClass." doesn't exist");

        $callInstance = (new Sender($this->di))->call($provider);

        $this->assertInstanceOf($providerClass, $callInstance, "[-] Provider instance error");
    }

    /**
     * @dataProvider additionErrorsDataProvider
     * @expectedException     \SMSFactory\Exceptions\BaseException
     * @expectedExceptionCode 503
     */
    public function testSendCatchExceptions($provider)
    {
        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/error.php'
            );
        });

        $callInstance = new Sender($this->di);

        $this->assertInstanceOf('SMSFactory\Sender', $callInstance, "[-] Provider instance error");

        $callInstance->call($provider)->debug(true)->setRecipient($this->phone)->send($this->message);
    }

    /**
     * @dataProvider additionDataProvider
     */
    public function testBalance($provider)
    {

        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/config.php'
            );
        });

        $callInstance = new Sender($this->di);

        $this->assertInstanceOf('SMSFactory\Sender', $callInstance, "[-] Provider instance error");

        $result = $callInstance->call($provider)->debug(false)->balance();

        $this->assertNotEmpty($result, "[-] Result can not be empty");
    }
}


 