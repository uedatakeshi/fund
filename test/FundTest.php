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
        $this->fund = new Fund\Mstar("2018083102");
    }

    // テスト処理
    public function testGetName()
    {
        $name = "ueda";
        $this->assertEquals($name, $this->fund->getName());
    }

    public function test_strToArrayo()
    {
        $html = <<<END
日付,価格
20210419,30000
20210420,30000
END;
        $list = [
            [
                'price_date' => '20210419',
                'price' => '30000'
            ],
            [
                'price_date' => '20210420',
                'price' => '30000'
            ]
        ];

        $this->assertEquals($list, $this->fund->_strToArray($html));
    }

    public function test_setFromTo()
    {
        $to_date_time = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $data = [
            'selectStdYearFrom' => "2018",
            'selectStdMonthFrom' => "08",
            'selectStdDayFrom' => "31",
            'selectStdYearTo' => date("Y", $to_date_time),
            'selectStdMonthTo' => date("m", $to_date_time),
            'selectStdDayTo' => date("d", $to_date_time),
        ];
        $this->assertEquals($data, $this->fund->_setFromTo());
    }

    public function test_setFromTo_fromari()
    {
        $from = "20211231";
        $to_date_time = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $data = [
            'selectStdYearFrom' => "2021",
            'selectStdMonthFrom' => "12",
            'selectStdDayFrom' => "31",
            'selectStdYearTo' => date("Y", $to_date_time),
            'selectStdMonthTo' => date("m", $to_date_time),
            'selectStdDayTo' => date("d", $to_date_time),
        ];
        $this->assertEquals($data, $this->fund->_setFromTo($from));
    }
}
