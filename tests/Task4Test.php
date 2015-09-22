<?php

namespace OpsWay\Migration\Tests;

use OpsWay\Migration\Processor\ReadWriteProcessor;
use OpsWay\Migration\Reader\ReaderFactory;
use OpsWay\Migration\Writer\WriterFactory;

class Task4Test extends \PHPUnit_Framework_TestCase {

    protected $output;

    public function setUp(){
        require_once 'vendor/autoload.php';
    }
    /**
     * Test without output buffering
     *
     * @outputBuffering enabled
     */
    public function testCheckAnswerTask4()
    {
        $_GET['reader'] = 'Db\\Product';
        $_GET['writer'] = 'Html';
        $argv[1] = 'Db\\Product';
        $argv[2] = 'Html';
        ob_start();
        include 'web.php';
        $resultOutput = trim(ob_get_contents());
        ob_end_clean();

        $processor = new ReadWriteProcessor(
            ReaderFactory::create('Db\\Product', include 'config/database.php'),
            WriterFactory::create('Html'),
            function () {}
        );
        ob_start();
        $processor->processing();
        $expectResult = trim(ob_get_contents());
        ob_end_clean();
        $this->assertEquals($expectResult, $resultOutput);

    }
}
