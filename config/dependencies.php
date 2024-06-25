<?php
use App\Router\Router;
use App\Repository\DatabaseFareRepository;
use App\Service\SimpleFareCalculator;
use Database\DatabaseConnection;

return [
    'router' => function() {
        return new Router();
    },
    'fareCalculator' => function() {
        return new SimpleFareCalculator();
    },
    'fareRepository' => function() {
        $pdo = (new DatabaseConnection())->getPdo();
        return new DatabaseFareRepository($pdo);
    }
];
