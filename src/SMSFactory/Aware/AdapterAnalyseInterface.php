<?php
namespace SMSFactory\Aware;

/**
 * Interface AdapterAnalyseInterface
 *
 * @since     PHP >=5.4
 * @version   1.0
 * @author    Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @package SMSFactory\Aware
 * @subpackage SMSFactory
 */
interface AdapterAnalyseInterface
{

    /**
     * Load input data
     *
     * @param mixed $data
     * @return void
     */
    public function import($data);

    /**
     * Analyse data
     *
     * @return mixed
     */
    public function process();

    /**
     * Issuance formatted results
     *
     * @return void
     */
    public function export();

}