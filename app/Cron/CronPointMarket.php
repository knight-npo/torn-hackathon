<?php

require __DIR__ . '/../../vendor/autoload.php';

use NPO\TornHackathon\Conf\Config;
use NPO\TornHackathon\Database\ConnectionProvider;
use NPO\TornHackathon\Model\Service\PointMarketService;

$db = ConnectionProvider::getInstance()->getConnection();
$conf = new Config();
(new PointMarketService($db, $conf))->updateMarkets();

echo date('c', time()) . ": Points Market Updated\n";
