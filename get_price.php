<?php
require_once "vendor/autoload.php";
//require_once 'config.php';

date_default_timezone_set('Asia/Tokyo');

$fund = new Fund\Mstar();
$fund->getPrice("2017011006");
