<?php

namespace OpsWay\Migration\Tests;

use OpsWay\Migration\Logger\ConsoleLogger;
use OpsWay\Migration\Processor\YieldProcessor;
use OpsWay\Migration\Reader\ReaderFactory;
use OpsWay\Migration\Writer\WriterFactory;

class Task6Test extends \PHPUnit_Framework_TestCase {

    protected $output;

    public function setUp(){
        require_once 'vendor/autoload.php';
    }

    public function testCheckAnswerTask6()
    {
        $this->assertTrue(class_exists('OpsWay\Migration\Reader\File\Csv'), 'Reader csv class does not exists.');
        $processorExpect = new YieldProcessor(
            ReaderFactory::create('Db\\Product', include 'config/database.php'),
            WriterFactory::create('Stub'),
            function () {}
        );
        $argv[1] = 'Db\\Product';
        $argv[2] = 'Stub';
        $config = include 'config.php';
        $processorResult = new YieldProcessor(
            ReaderFactory::create('File\\Csv', $config['params']),
            WriterFactory::create('Stub'),
            function () {}
        );
        $expectArray = iterator_to_array($processorExpect->processing(), true);
        $resultArray = iterator_to_array($processorResult->processing(), true);
        $this->assertEquals($expectArray, $resultArray);

        $this->assertTrue(class_exists('OpsWay\Migration\Logger\OutOfStockLogger'), 'OutOfStockLogger class does not exists.');
        $this->assertFileExists('data/output.log.csv');
        $file = file_get_contents('data/output.log.csv');
        $this->assertTrue(strpos($file, 'HR-1003') !== false);
        $this->assertTrue(strpos($file, 'HR-1005') !== false);
        $this->assertTrue(strpos($file, 'HR-1007') !== false);
    }
}
