<?php

namespace NPO\TornHackathon\Controller;

use NPO\TornHackathon\Conf\Config;
use NPO\TornHackathon\Database\ConnectionProvider;
use NPO\TornHackathon\Model\Service\PointMarketService;
use NPO\TornHackathon\View\PointMarketView;

class PointMarketController implements Controller {
    private $db;
    private $conf;
    private $ts;

    public function __construct() {
        $this->db = ConnectionProvider::getInstance()->getConnection();
        $this->conf = new Config();
        $this->ts = new PointMarketService($this->db, $this->conf);
    }

    public function load() {
        $this->ts->updateMarkets();
    }

    public function index() {
        $pointsMarket = $this->ts->getAll();
        (new PointMarketView())->render(['pointsMarket' => $pointsMarket]);
    }
}
