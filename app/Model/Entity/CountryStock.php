<?php

namespace NPO\TornHackathon\Model\Entity;

class CountryStock {
    public function __construct(
        private $country,
        private $countryName,
        private $items,
        private $updated,
    ) {
    }

    public function getCountry() {
        return $this->country;
    }

    public function getCountryName() {
        return $this->countryName;
    }

    public function getItems() {
        return $this->items;
    }

    public function getUpdated() {
        return $this->updated;
    }
}
