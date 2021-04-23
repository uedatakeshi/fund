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

}
