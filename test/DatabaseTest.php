<?php
/*
 * 実行方法；
 * cd fund
 * vendor/phpunit/phpunit/phpunit ./test/DatabaseTest.php
 *
 */
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{

    public function setUp()
    {
        $this->conn = new Fund\Database();
    }

    // テスト処理
    public function testGetLatestPrice()
    {
        $ms_code = "2017011006";
        $price = ['price_date' => "2021-04-20", 'price' => 19000];
        $this->assertEquals($price, $this->conn->getLatestPrice($ms_code));
    }

    // 配列からインサートする
    public function testInsertPrice()
    {
        $price[] = ['ms_code' => '2017011006', 'price_date' => "2020-12-10", 'price' => 29000];
        $this->assertTrue($this->conn->insertPrice($price));
    }

}
