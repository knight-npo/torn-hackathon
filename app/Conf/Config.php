<?php

namespace NPO\TornHackathon\Conf;

class Config {
    public function getDBDriver() {
        return "mysql";
    }

    public function getDBHost() {
        return getenv("DB_HOST");
    }

    public function getDBPort() {
        return getenv("DB_PORT");
    }

    public function getDBUser() {
        return getenv("DB_USER");
    }

    public function getDBPass() {
        return getenv("DB_PASS");
    }

    public function getDBName() {
        return getenv("DB_NAME");
    }

    public function getUpdateInterval() {
        return getenv("UPDATE_INTERVAL");
    }

    public function getAPIKey() {
        return getenv("API_KEY");
    }
}
