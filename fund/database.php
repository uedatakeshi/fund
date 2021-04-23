<?php
namespace Fund;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Database
{
    public $conn = "";
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
        $data = [];
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
            $data['price_date'] = $row[0];
            $data['price'] = $row[1];
        }

        return $data;
    }

    public function insertPrice($price) {
        if ($price) {
            foreach ($price as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    $price[$k][$k2] = pg_escape_string($v2);
                }
            }
            foreach ($price as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    $query = <<<END
                    SELECT id FROM prices 
                        WHERE 
                        ms_code = '{$v['ms_code']}' AND 
                        price_date = '{$v['price_date']}' 
END;
                    $result = pg_query($this->conn, $query);
                    if (pg_num_rows($result) == 0) {
                        $query = <<<END
                        INSERT INTO prices  (
                            ms_code, price_date, price
                        ) VALUES (
                            '{$v['ms_code']}', '{$v['price_date']}', '{$v['price']}'
                        )
END;
                        $result = pg_query($this->conn, $query);
                        if (!$result) {
                            $this->log->error("DB INSERT error", [$query]);
                            return false;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }



}
