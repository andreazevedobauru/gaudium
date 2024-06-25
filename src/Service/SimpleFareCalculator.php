<?php
namespace App\Service;

class SimpleFareCalculator implements IFareCalculator {
    public function calculate($distance, $duration) {
        return $distance * 1.5 + $duration * 0.5;  // Cálculo fictício
    }
}