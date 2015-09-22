<?php

namespace OpsWay\Migration\Logger;

class OutOfStockLogger
{
    static public $countItem = 0;
    protected $debug;
    protected $filename;
    

    public function __construct($mode = false)
    {
        $this->debug = $mode;
        $this->filename = $_SERVER['DOCUMENT_ROOT'] . 'data/output.log.csv';
    }

    public function __invoke($item, $status, $msg)
    {
        if ((++self::$countItem % 2) == 0 && $this->debug) {
            file_put_contents($this->filename, self::$countItem . " ",  FILE_APPEND);
        }
        if (!$status) {
            echo "Warning: " . $msg . print_r($item, true) . PHP_EOL;
        }
    }
}
