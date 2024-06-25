<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/bootstrap.php';

use App\Router\Router;

// Inicializando dependências
$services = require __DIR__ . '/../config/dependencies.php';

$router = new Router();

// Incluir a configuração de rotas
(require __DIR__ . '/../config/routes.php')($router);