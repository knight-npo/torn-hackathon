<?php

namespace NPO\TornHackathon\Controller;

use NPO\TornHackathon\Conf\Config;
use NPO\TornHackathon\Database\ConnectionProvider;
use NPO\TornHackathon\Model\Service\TravelStockService;
use NPO\TornHackathon\View\TravelStockView;

class TravelStockController implements Controller {
    private $db;
    private $conf;
    private $ts;

    public function __construct() {
        $this->db = ConnectionProvider::getInstance()->getConnection();
        $this->conf = new Config();
        $this->ts = new TravelStockService($this->db, $this->conf);
    }

    public function load() {
        $this->ts->updateStocks();
    }

    public function index() {
        $stock = $this->ts->getAllStocks();
        (new TravelStockView())->render(['stocks' => $stock]);
    }
}
