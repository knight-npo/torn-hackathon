<?php

namespace NPO\TornHackathon\Model\Service;

class FetchFailedException extends \Exception {
    public function __construct($err) {
        parent::__construct("Failed to fetch: " . $err);
    }
}
