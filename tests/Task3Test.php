<?php

namespace OpsWay\Migration\Tests;

use OpsWay\Migration\Processor\YieldProcessor;
use OpsWay\Migration\Reader\ReaderFactory;
use OpsWay\Migration\Writer\WriterFactory;

class Task3Test extends \PHPUnit_Framework_TestCase {

    public function setUp(){
        require_once 'vendor/autoload.php';
    }

    public function testCheckAnswerTask3()
    {
        $this->assertFileExists('data/export.csv');

        $filecsv = new \SplFileObject('data/export.csv');
        $filecsv->setFlags(\SplFileObject::READ_CSV);
        $header = $filecsv->current();

        $processor = new YieldProcessor(
            ReaderFactory::create('Db\\Product', include 'config/database.php'),
            WriterFactory::create('Stub'),
            function () {}
        );

        foreach ($processor->processing() as $item) {
            $filecsv->next();
            $this->assertEquals($item, array_combine($header,$filecsv->current()));
        }
    }
}
