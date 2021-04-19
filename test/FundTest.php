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
        $name = "yamada";

        // 配列（$array）の要素数が３つであることをテストする。
        $this->assertEquals($name, $this->fund->getName());
    }
}
