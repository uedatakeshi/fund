<?php
require_once "vendor/autoload.php";
//require_once 'config.php';

date_default_timezone_set('Asia/Tokyo');

$con = new Fund\Database();
$fund = new Fund\Mstar("2017011006");
//$csvdata = $fund->getPrice("2017011006");
//$price_array = $fund->_strToArray($csvdata);


$con->getLatestPrice("2017011006");
//print_r($price_array);
