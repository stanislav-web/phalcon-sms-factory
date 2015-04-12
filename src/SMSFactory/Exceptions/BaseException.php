<?php

namespace SMSFactory\Exceptions;

/**
 * Class BaseException. Error trapping is associated with inaccurate data or arguments.
 *
 * @package SMSFactory
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /SMSFactory/Exceptions/BaseException.php
 */
class BaseException extends \Exception {

    /**
     * Service Unavailable for each trowed errors
     */
    const CODE = 503;

    /**
     * Constructor
     *
     * @param string $provider SMS Provider
     * @param string $message error message
     * @param int $code error code
     */
    public function __construct($provider, $message, $code = null) {

        if(null === $code) {
            $code = self::CODE;
        }
        parent::__construct($provider.': '.$message, $code);
    }
}