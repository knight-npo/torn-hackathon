<?php

namespace NPO\TornHackathon\Database;

use NPO\TornHackathon\Conf\Config;
use PDO;

class ConnectionProvider {
    public static $instance;
    private $conf;

    private function __construct() {
        $this->conf = new Config();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection() {
        $conn = new PDO(
            sprintf(
                "%s:host=%s;port=%s;dbname=%s",
                $this->conf->getDBDriver(),
                $this->conf->getDBHost(),
                $this->conf->getDBPort(),
                $this->conf->getDBName(),
            ),
            $this->conf->getDBUser(),
            $this->conf->getDBPass()
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
