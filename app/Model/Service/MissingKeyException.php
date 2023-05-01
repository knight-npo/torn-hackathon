<?php

namespace NPO\TornHackathon\Model\Service;

class MissingKeyException extends \Exception {
    public function __construct() {
        parent::__construct("Missing API Key");
    }
}
