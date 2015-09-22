<?php

namespace OpsWay\Migration\Tests;

class Task1Test extends \PHPUnit_Framework_TestCase {

    public function testCheckAnswerTask1()
    {
        $this->assertFileExists('data/comments/1.txt');
        $this->assertGreaterThan(300, strlen(file_get_contents('data/comments/1.txt')));
    }
}
