<?php

require __DIR__ . '/../../vendor/autoload.php';

use NPO\TornHackathon\Conf\Config;
use NPO\TornHackathon\Database\ConnectionProvider;
use NPO\TornHackathon\Model\Service\TravelStockService;

$db = ConnectionProvider::getInstance()->getConnection();
$conf = new Config();
(new TravelStockService($db, $conf))->updateStocks();

echo date('c', time()) . ": Travel Stock Updated\n";
