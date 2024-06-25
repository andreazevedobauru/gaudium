<?php
namespace App\Service;

interface IFareCalculator {
    public function calculate($distance, $duration);
}