<?php

namespace OpsWay\Migration\Tests;

use OpsWay\Migration\Processor\YieldProcessor;
use OpsWay\Migration\Reader\ReaderFactory;
use OpsWay\Migration\Writer\WriterFactory;

class Task2Test extends \PHPUnit_Framework_TestCase {

    public function setUp(){
        require_once 'vendor/autoload.php';
    }

    public function testCheckAnswerTask2()
    {
        $this->assertFileExists('data/2.txt');
        $this->assertFileExists('data/comments/2.txt');
        $this->assertGreaterThan(0, strlen(file_get_contents('data/comments/2.txt')));

        $file = file_get_contents('data/2.txt');
        $this->assertContains('Start Time', $file);
        $this->assertContains('End Time', $file);

        $processor = new YieldProcessor(
            ReaderFactory::create('Db\\Product', include 'config/database.php'),
            WriterFactory::create('Stub'),
            function () {}
        );
        $file = explode("\n",$file);
        $i = 2;
        foreach ($processor->processing() as $item) {
            $this->assertEquals(implode(", ", $item), trim($file[$i++]));
        }
    }
}
