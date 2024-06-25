<?php
use App\Controller\UserController;
use App\Controller\FareCalculationController;
use App\Router\Router;

return function (Router $router) use ($services) {
    $router->add('GET', '/', [new UserController(), 'index']);
    $router->add('GET', '/teste', [new UserController(), 'teste']);
    $router->add('POST', '/calculate-fare', [new FareCalculationController(
        $services['fareCalculator'](),
        $services['fareRepository']()
    ), 'calculateFare']);
};
