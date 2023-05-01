<?php

namespace NPO\TornHackathon\Model\Entity;

class PointMarket {
    public function __construct(
        private $cost,
        private $quantity,
        private $totalCost
    ) {
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getCost() {
        return $this->cost;
    }

    public function getTotalCost() {
        return $this->totalCost;
    }
}
