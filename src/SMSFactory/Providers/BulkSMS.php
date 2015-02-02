<?php
namespace Submissions\Provider;

use Submissions\Exception;
use Submissions\Aware;

// Here should implemented only those libraries that are needed for this provider
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;

/**
 * BulkSMS Internet SMS Gateway. Powered by Protocol interaction with providers sms service BulkSMS.
 * @package Zend Framework 2
 * @subpackage Submissions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @license Zend Framework GUI licene
 * @filesource /module/Submissions/src/Submissions/Provider/BulkSMS.php
 */
class BulkSMS extends \ReflectionClass implements Aware\ProviderInterface {

    /**
     * $_sm Service Manager
     * @access private
     * @var object
     */
    private $_sm    =   null;

    /**
     * $__config Configuration for this provider (Cannot modify outside)
     * @see getConfig()
     * @access private
     * @var array $config
     */
    private $__config  =   null;

    /**
     * $__adapterConfig Adapter connection settings
     * @see getAdapterConfig()
     * @access private
     * @var array $config
     */
    private $__adapterConfig  =   null;

    /**
     * __construct(\Zend\ServiceManager\ServiceManager $ServiceManager)
     * @param \Zend\ServiceManager\ServiceManager $ServiceManager
     * @return instance of ServiceManager, Provider Configuration
     *
     */
    public function __construct(\Zend\ServiceManager\ServiceManager $ServiceManager)
    {
        parent::__construct(__CLASS__);

        // set ServiceManager throught constructor
        if(null === $this->_sm)  $this->_sm =   $ServiceManager;
        $this->__config   =   $this->_sm->get('Config')["Submissions\Provider\Config"][$this->getShortName()];
    }

    /**
     * send($params) Send SMS
     * @param array $params [msisdn, message] required
     * @acces public
     * @return array
     */
    public function send($params)
    {
        if(!array_key_exists('msisdn', $params) && !array_key_exists('message', $params)) throw new Exception\ExceptionStrategy($this->getShortName().' miss required oprions');
        return $this->sendRequest(null, $params);
    }

    /**
     * getConfig() Get provider configurations
     * @access public
     * @see Aware\ProviderInterface
     * @return array
     * @throws Exception\ExceptionStrategy
     */
    public function getConfig()
    {
        if(empty($this->__config))   throw new Exception\ExceptionStrategy($this->getShortName().' config file is empty');
        return $this->__config;
    }

    /**
     * getAdapterConfig() Get adapter configuration by default
     * @access public
     * @see Aware\ProviderInterface
     * @return array
     */
    public function getAdapterConfig()
    {
        if(empty($this->__adapterConfig))   throw new Exception\ExceptionStrategy($this->getShortName().' connection adapter is not configured');
        return $this->__adapterConfig;
    }

    /**
     * __setAdapterConfig() Set adapter additional configuration
     * @param array $adapterConfig  additional configurations
     * @access private
     * @return array
     */
    private function __setAdapterConfig(array $adapterConfig)
    {
        $this->__adapterConfig  =   $adapterConfig+$this->__config['adapter'];
    }

    /**
     * sendRequest(array $data = null) Send request and get response from internal server
     * @param array [msisdn, message] $data request data
     * @see Aware\ProviderInterface
     * @return json data
     */
    public function sendRequest($uri = null, array $data = null)
    {
        // Compile URL from pattern
        $url = strtr($this->__config['api_url_pattern'], [
                ':username' =>  $this->__config['username'],
                ':password' =>  $this->__config['password'],
                ':message'  =>  urlencode($data['message']),
                ':msisdn'   =>  urlencode($data['msisdn']),
            ]
        );

        // set Client adapter config
        $this->__setAdapterConfig([]);

        // Do the request to server with POST data
        $adapter = new Curl();
        $adapter->setOptions([
            'curloptions' => $this->getAdapterConfig()
        ]);

        $client = new Client($url);
        $client->setAdapter($adapter);
        $client->setMethod('POST');
        $client->setParameterPost($data);
        $response = $client->send($client->getRequest());

        if($response->getStatusCode() != 200)
            throw new Exception\ExceptionStrategy($this->getShortName().' connection error. Code: '.$response->getStatusCode());

        $parseResult = explode('|', trim($response->getContent()));

        if($parseResult[0] > 0) $result['result']['error']    =   $parseResult[1];
        else $result['result']  =   $parseResult[1];

        // Return result
        return $result;
    }
}
