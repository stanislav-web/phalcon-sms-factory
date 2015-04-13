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
     * DependencyInjector service
     *
     * @var \Phalcon\DI\FactoryDefault $di
     */
    private $di;

    /**
     * Configuration file
     *
     * @var \Phalcon\Config $config
     */
    private $config;

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

        $this->di->set('config', function() {
            return new Config(
                require './phpunit/data/config.php'
            );
        });

        $this->config = $this->di->get('config');
        $this->reflection = new \ReflectionClass('\SMSFactory\Sender');
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     * @example <code>
     *                           $this->invokeMethod($user, 'cryptPassword', array('passwordToCrypt'));
     *                           </code>
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $method = $this->reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
    /**
     * Setup accessible any private (protected) property
     *
     * @param $name
     * @return \ReflectionMethod
     */
    protected function getProperty($name)
    {
        $prop = $this->reflection->getProperty($name);
        $prop->setAccessible(true);
        return $prop;
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
     * @covers SMSFactory\Sender::call
     * @expectedException     \SMSFactory\Exceptions\BaseException
     * @expectedExceptionCode 500
     */
    public function testCallException()
    {
        (new Sender($this->di))->call('Undefined');
    }

    /**
     * @dataProvider additionProvider
     * @covers SMSFactory\Sender::call
     */
    public function testCall($provider)
    {
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
     * Get SMS Providers
     *
     * @return array
     */
    public function additionProvider()
    {
        $this->config = new Config(
            require './phpunit/data/config.php'
        );

        $data = [];
        $providers = array_keys($this->config->sms->toArray());

        foreach($providers as $provider) {
            $data[] = array($provider);
        }
        return $data;
    }
}


 