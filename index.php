<?php

require './vendor/autoload.php';

use NPO\TornHackathon\Controller\PointMarketController;
use NPO\TornHackathon\Controller\TravelStockController;

$uri = $_SERVER['REQUEST_URI'];

if ($uri === "/points-market") {
    (new PointMarketController())->index();
} elseif ($uri === "/travel-stock") {
    (new TravelStockController())->index();
} else {
    header('Location: /travel-stock');
}
