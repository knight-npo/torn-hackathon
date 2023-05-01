<?php

namespace NPO\TornHackathon\Model\Service;

use NPO\TornHackathon\Model\Entity\PointMarket;

class PointMarketService {
    public function __construct(private $db, private $conf) {
    }

    public function getAll() {
        $q = 'SELECT * FROM points_market';
        $markets = [];
        foreach ($this->db->query($q) as $row) {
            array_push($markets, new PointMarket(
                $row['cost'],
                $row['quantity'],
                $row['total_cost']
            ));
        }

        return $markets;
    }

    public function updateMarkets() {
        $key = $this->conf->getAPIKey();
        if (strlen($key) == 0) {
            throw new MissingKeyException();
        }
        $url = "https://api.torn.com/market/?selections=pointsmarket&key=" . $key;

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
        $db = $this->db;
        if (!$db->beginTransaction()) {
            throw new FetchFailedException('could not begin transaction');
        }

        try {
            if ($db->exec('DELETE FROM points_market') === false) {
                throw new FetchFailedException('failed to delete market data');
            }

            $q = 'INSERT INTO points_market(quantity, cost, total_cost) VALUES';
            foreach ($data['pointsmarket'] as $key => $market) {
                $q .= sprintf(
                    "(%d, %d, %d),",
                    $market['quantity'],
                    $market['cost'],
                    $market['total_cost']
                );
            }
            $q = substr($q, 0, -1);
            if ($db->exec($q) === false) {
                throw new FetchFailedException("failed to update points_market");
            }

            $q = sprintf('UPDATE svc_log
                SET last_updated = FROM_UNIXTIME(%d)
                WHERE svc = "points_market"', time());
            $db->exec($q);
            if ($db->commit() === false) {
                throw new FetchFailedException("failed to commit points_market");
            }
        } catch (\Exception $ex) {
            $db->rollBack();
            throw $ex;
        }
    }
}
