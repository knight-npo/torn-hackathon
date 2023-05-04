<?php

require './vendor/autoload.php';

use NPO\TornHackathon\Conf\Config;
use NPO\TornHackathon\Controller\PointMarketController;
use NPO\TornHackathon\Controller\TravelStockController;

$uri = $_SERVER['REQUEST_URI'];

if ($uri === "/points-market") {
    (new PointMarketController())->index();
} elseif ($uri === "/travel-stock") {
    (new TravelStockController())->index();
} else {
    $basePath = (new Config())->getBasePath();
    if (!str_starts_with($basePath, '/')) {
        $basePath = '/' . $basePath;
    }
    if (!str_ends_with($basePath, '/')) {
        $basePath .= '/';
    }

    header('Location:  ' . $basePath . 'travel-stock');
}
