<?php
/*
 * 実行方法；
 * cd fund
 * vendor/phpunit/phpunit/phpunit ./test/FundTest.php
 *
 */
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

class FundTest extends TestCase
{

    public function setUp()
    {
        $this->fund = new Fund\Mstar();
    }

    // テスト処理
    public function testGetName()
    {
        $name = "ueda";
        $this->assertEquals($name, $this->fund->getName());
    }

    public function test_setFromTo()
    {
        $ms_code = "2018083102";
        $from = "";
        $to_date_time = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $data = [
            'selectStdYearFrom' => "2018",
            'selectStdMonthFrom' => "08",
            'selectStdDayFrom' => "31",
            'selectStdYearTo' => date("Y", $to_date_time),
            'selectStdMonthTo' => date("m", $to_date_time),
            'selectStdDayTo' => date("d", $to_date_time),
        ];
        $this->assertEquals($data, $this->fund->_setFromTo($ms_code, $from));
    }

    public function test_setFromTo_fromari()
    {
        $ms_code = "2018083102";
        $from = "2021-12-31";
        $to_date_time = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $data = [
            'selectStdYearFrom' => "2021",
            'selectStdMonthFrom' => "12",
            'selectStdDayFrom' => "31",
            'selectStdYearTo' => date("Y", $to_date_time),
            'selectStdMonthTo' => date("m", $to_date_time),
            'selectStdDayTo' => date("d", $to_date_time),
        ];
        $this->assertEquals($data, $this->fund->_setFromTo($ms_code, $from));
    }
}
