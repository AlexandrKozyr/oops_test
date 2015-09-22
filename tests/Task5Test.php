<?php

namespace OpsWay\Migration\Tests;

use OpsWay\Migration\Logger\ConsoleLogger;

class Task5Test extends \PHPUnit_Framework_TestCase {

    protected $output;

    public function setUp(){
        require_once 'vendor/autoload.php';
    }

    public function testCheckAnswerTask5()
    {
        $this->assertFileExists('new_cli.php');
        $argv[1] = 'Db\\Product';
        $argv[2] = 'Stub';
        ob_start();
        include 'new_cli.php';
        $output = trim(ob_get_contents());
        $output = trim(explode("\n", $output)[1]);
        ob_end_clean();
        $this->assertNotInstanceOf(ConsoleLogger::class, $processor->getLogger());
        $this->assertInstanceOf(\Closure::class, $processor->getLogger());
        $this->assertEquals('2 4 6 8 10', $output);
    }
}
