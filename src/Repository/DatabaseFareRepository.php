<?php
namespace App\Repository;

use IFareRepository;

class DatabaseFareRepository implements IFareRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveCalculation($data) {
        $stmt = $this->pdo->prepare('INSERT INTO fare_calculations 
            (city_id, category_id, origin_address, destination_address, distance, duration, fare_amount, date_time) VALUES 
            (?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute($data);
    }
}
