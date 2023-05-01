<?php

namespace NPO\TornHackathon\Model\Service;

use NPO\TornHackathon\Model\Entity\CountryStock;
use NPO\TornHackathon\Model\Entity\ItemStock;

class TravelStockService {
    public function __construct(private $db, private $conf) {
    }

    public function getAllStocks() {
        $q = 'SELECT * FROM item_stocks it';
        $itemStocks = [];

        foreach ($this->db->query($q) as $row) {
            $country = $row['country'];
            if (!isset($itemStocks[$country])) {
                $itemStocks[$country] = [];
            }
            array_push($itemStocks[$country], new ItemStock(
                $row['item_id'],
                $row['item_name'],
                $row['quantity'],
                $row['cost']
            ));
        }

        $results = [];
        $q = "SELECT st.country, UNIX_TIMESTAMP(st.updated) AS updated, c.*
                FROM country_stocks st
                JOIN countries c ON c.id = st.country";

        foreach ($this->db->query($q) as $row) {
            $country = $row['country'];
            $results[$country] = new CountryStock(
                $country,
                $row['name'],
                $itemStocks[$country],
                $row['updated']
            );
        }

        return $results;
    }

    public function updateStocks() {
        $url = "https://yata.yt/api/v1/travel/export/";
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($status != 200) {
                throw new FetchFailedException($response);
            }

            $data = json_decode($response, true);
            $this->insertData($data);
        } finally {
            curl_close($curl);
        }
    }

    private function insertData($data) {
        $stocks = $data['stocks'];
        $timestamp = $data['timestamp'];
        $countryQ = $this->db->prepare('
            INSERT INTO country_stocks (country, updated)
            VALUES(?, FROM_UNIXTIME(?))
            ON DUPLICATE KEY UPDATE updated = VALUES(updated)
        ');

        foreach ($stocks as $country => $itemStock) {
            if (!$countryQ ->execute([$country, $itemStock['update']])) {
                throw new FetchFailedException("failed to update country_stocks");
            }

            $q = 'INSERT INTO item_stocks(country, item_id, item_name, quantity, cost) VALUES';
            foreach ($itemStock['stocks'] as $item) {
                $q .= sprintf(
                    "('%s', %d, '%s', %d, %d),",
                    $country,
                    $item['id'],
                    $item['name'],
                    $item['quantity'],
                    $item['cost']
                );
            }
            $q = substr($q, 0, -1);

            $q .= ' ON DUPLICATE KEY UPDATE
                    item_name = VALUES(item_name),
                    quantity = VALUES(quantity),
                    cost = VALUES(cost)';
            if (!$this->db->query($q)) {
                throw new FetchFailedException("failed to update items_stocks");
            }
        }

        $q = sprintf('UPDATE svc_log
            SET last_updated = FROM_UNIXTIME(%d)
            WHERE svc = "travel_stocks"', $timestamp);
        $this->db->query($q);
    }
}
