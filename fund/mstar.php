<?php
namespace Fund;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Mstar
{
    public $name = "ueda";
    public $apikey = "a68e2d55951b4756a3131f7942974eeb";
    public $mode = "dev";
    public $url = "https://www.morningstar.co.jp/FundData/DownloadStdYmd.do?fnc=";
    public $log;

    function __construct()
    {
        $this->log = new Logger('morning star');
        $this->log->pushHandler(new StreamHandler('./log/error.log', Logger::WARNING));
		//$this->getName();
    }

    public function getName() {
        echo $this->name;
        $this->log->error("リクエスト失敗", [1,2,3]);
    }

    public function getPrice($ms_code) {
        $url = $this->url . $ms_code;
        $data = array();
        if (preg_match('/^(\d{4})(\d{2})(\d{2})(\d+)$/', $ms_code, $regs)) {
            $data['selectStdYearFrom'] = $regs[1];
            $data['selectStdMonthFrom'] = $regs[2];
            $data['selectStdDayFrom'] = $regs[3];
        }
        $data['selectStdYearTo'] = date("Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        $data['selectStdMonthTo'] = date("m", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        $data['selectStdDayTo'] = date("d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

        $this->log->error("期間", $data);

        $context = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',)),
                'content' => http_build_query($data)
            )
        );

        $html = file_get_contents($url, false, stream_context_create($context));

        echo $html;



    }
}
