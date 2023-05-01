<?php

namespace NPO\TornHackathon\Model\Entity;

class ItemStock {
    public function __construct(
        private $itemId,
        private $itemName,
        private $quantity,
        private $cost,
    ) {
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getItemName() {
        return $this->itemName;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getCost() {
        return $this->cost;
    }
}
