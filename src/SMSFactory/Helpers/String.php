<?php
namespace SMSFactory\Helpers;

/**
 * Class String. String Helper
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Helpers
 * @subpackage SMSFactory
 */
class String
{

    /**
     * Check if a string is json valid
     *
     * @param string $string
     * @return bool
     */
    public static function isJson($string)
    {

        return ((is_string($string) === true &&
            (is_object(json_decode($string)) === true ||
                is_array(json_decode($string)) === true))) ? true : false;
    }
}