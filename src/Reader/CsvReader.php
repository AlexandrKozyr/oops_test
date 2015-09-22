<?php

namespace OpsWay\Migration\Reader;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use OpsWay\Migration\Reader\ReaderInterface;

class CsvReader implements ReaderInterface {

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $filename;
    protected $info;

    public function __construct() {
        $this->filename = $_SERVER['DOCUMENT_ROOT'] . 'data/export.csv';
        $this->checkFileName();
        $this->getInfo();
    }

    /**
     * @return array|null
     */
    public function getInfo() {
        $item = file_get_contents($this->filename);

        $csv_array    = explode("\n", $item);
        array_pop($csv_array);
        $next_lvl_csv = array();
        foreach ($csv_array as $csv) {
            $next_lvl_csv[] = explode(",", $csv);
        }
        $count  = count($next_lvl_csv);
        $result = array();
        for ($i = 0; $i < $count; $i++) {
            if ($next_lvl_csv[$i][3] == 'qty' || ($next_lvl_csv[$i][3] == 0 && $next_lvl_csv[$i][4] == 0)) {
                $result[] = $next_lvl_csv[$i];
            }
        }
        $lresult = array();
        $count2  = count($result);
        for ($i = 1; $i < $count2; $i++) {
            $lresult[$i][$result[0][0]] = $result[$i][0];
            $lresult[$i][$result[0][1]] = $result[$i][1];
            $lresult[$i][$result[0][2]] = $result[$i][2];
            $lresult[$i][$result[0][3]] = $result[$i][3];
            $lresult[$i][$result[0][4]] = $result[$i][4];
        }
        $this->info = $lresult;
    }

    public function read() {
        return array_shift($this->info);
    }

    private function checkFileName() {
        if (!file_exists($this->filename)) {
            throw new \RuntimeException(sprintf('File "%s" was not found. Check it and run again.', $this->filename));
        }
    }

}
