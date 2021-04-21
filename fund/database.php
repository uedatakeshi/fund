<?php
namespace Fund;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Database
{
    public $conn = "";
    public $url = "https://www.morningstar.co.jp/FundData/DownloadStdYmd.do?fnc=";
    public $ms_code = "";
    public $log;

    function __construct()
    {
        $this->log = new Logger('database');
        $this->log->pushHandler(new StreamHandler('./log/error.log', Logger::WARNING));

        $this->conn = pg_pconnect("dbname=fund_db user=postgres");
        if (! $this->conn) {
            $this->log->error("DBê⁄ë±", [1]);
            exit;
        }
    }

    public function getLatestPrice($ms_code) {
        $ms_code = pg_escape_string($ms_code);
        $query = <<<END
        SELECT price_date, price 
        FROM prices 
        WHERE ms_code='{$ms_code}' 
        ORDER BY price_date DESC 
        LIMIT 1
END;
        $result = pg_query($this->conn, $query);
        if (!$result) {
            $this->log->error("DB SELECT error", [$query]);
            exit;
        }
        while ($row = pg_fetch_row($result)) {
            echo "Date: $row[0]  Price: $row[1]";
            echo "<br />\n";
        }
    }

}
