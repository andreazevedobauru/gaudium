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
    $router->add('GET', '/categories', function() use ($categoryController) {
        if (isset($_GET['city_id'])) {
            $categoryController->getCategoriesByCity($_GET['city_id']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'City ID is required']);
        }
    });
};
