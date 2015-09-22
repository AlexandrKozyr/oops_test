<?php

use OpsWay\Migration\Logger\ConsoleLogger;
use OpsWay\Migration\Processor\ReadWriteProcessor;
use OpsWay\Migration\Reader\ReaderFactory;
use OpsWay\Migration\Writer\WriterFactory;

$config = include 'config.php';


if (defined('CLI_MODE') && CLI_MODE === false) {
    die('This can be run only on CLI mode.' . PHP_EOL);
}
echo "Start Time: " . date("d-m-Y H:i:s") . PHP_EOL;

try {
    //$c and $counter globals for debug 
    $c = 0;
    $counter = array();
    $processor = new ReadWriteProcessor(
            ReaderFactory::create($config['reader'], $config['params']),
            WriterFactory::create($config['writer'], $config['params']),
            //anonim function for debug
            function($item, $status, $msg) {
                global $c, $counter;
                if (( ++$c % 2) == 0) {
                    array_push($counter, $c);
                }
                if (!$status) {
                    echo "Warning: " . $msg . print_r($item, true) . PHP_EOL;
            }
    }
    );
    //Processing
    $processor->processing();
    
    //debuging counter showing
    $debug = implode(" ", $counter);
    echo "debug info : ".$debug;
    
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
} finally {
    echo PHP_EOL;
}

echo "End Time: " . date("d-m-Y H:i:s") . PHP_EOL;
