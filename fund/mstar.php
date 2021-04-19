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
    public $ms_code = "";
    public $log;

    function __construct($ms_code)
    {
        $this->ms_code = $ms_code;
        $this->log = new Logger('morning star');
        $this->log->pushHandler(new StreamHandler('./log/error.log', Logger::WARNING));
		$this->getName();
    }

    public function getName() {
        $this->log->error("リクエスト失敗", [1,2,3]);
        return $this->name;
    }

    public function getPrice() {
        $url = $this->url . $this->ms_code;
        $data = $this->_setFromTo();

        $context = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',)),
                'content' => http_build_query($data)
            )
        );

        $html = file_get_contents($url, false, stream_context_create($context));

        return $html;
    }

    public function _setFromTo($from = null) {

        $data = array();
        if (!$from) {
            $from = $this->ms_code;
        }
        if (preg_match('/^(\d{4})(\d{2})(\d{2})/', $from, $regs)) {
            $data['selectStdYearFrom'] = $regs[1];
            $data['selectStdMonthFrom'] = $regs[2];
            $data['selectStdDayFrom'] = $regs[3];
        }

        $to_date = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $to_date, $regs)) {
            $data['selectStdYearTo'] = $regs[1];
            $data['selectStdMonthTo'] = $regs[2];
            $data['selectStdDayTo'] = $regs[3];
        }
        $this->log->error("期間", $data);

        return $data;

    }

    public function _strToArray($html) {
        $lines = explode("\n", $html);
        $i = 0;
        $list = array();
        foreach ($lines as $k => $v) {
            list($price_date, $price) = explode(",", trim($v));
            if ($price) {
                $list[$i]['price_date'] = $price_date;
                $list[$i]['price'] = $price;
                $i++;
            }
        }

        return $list;

    }
}
