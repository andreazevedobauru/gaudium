<?php
namespace App\Controller;

use App\Service\IFareCalculator;
use IFareRepository;
use PDOException;

class FareCalculationController {
    private $fareCalculator;
    private $fareRepository;

    public function __construct(IFareCalculator $fareCalculator, IFareRepository $fareRepository) {
        $this->fareCalculator = $fareCalculator;
        $this->fareRepository = $fareRepository;
    }

    public function calculateFare() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            exit;
        }

        $cityId = filter_input(INPUT_POST, 'city_id', FILTER_SANITIZE_NUMBER_INT);
        $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $originAddress = filter_input(INPUT_POST, 'origin_address', FILTER_SANITIZE_STRING);
        $destinationAddress = filter_input(INPUT_POST, 'destination_address', FILTER_SANITIZE_STRING);

        if (!$cityId || !$categoryId || !$originAddress || !$destinationAddress) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input data']);
            exit;
        }

        $distance = mt_rand(0, 100);
        $duration = mt_rand(0, 60);
        $calculatedFare = $this->fareCalculator->calculate($distance, $duration);

        try {
            $this->fareRepository->saveCalculation([
                $cityId, $categoryId, $originAddress, $destinationAddress, $distance, $duration, $calculatedFare
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to record fare calculation']);
            exit;
        }

        echo json_encode([
            'distance' => $distance,
            'duration' => $duration,
            'calculatedFare' => $calculatedFare,
            'parameters' => [
                'city_id' => $cityId,
                'category_id' => $categoryId,
                'origin_address' => $originAddress,
                'destination_address' => $destinationAddress
            ]
        ]);
    }
}
