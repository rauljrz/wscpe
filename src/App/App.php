<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';
$baseDir = __DIR__ . '/../../';

$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$envFile = $baseDir . '.env';

if (file_exists($envFile)) {
    $dotenv->load();
}
date_default_timezone_set("America/Argentina/Buenos_Aires");
//$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);

$container = new \DI\Container();
$settings = require __DIR__ . '/Settings.php';
$settings($container);

$logger = require __DIR__ . '/Logger.php';
$logger($container);

# Inicializo la aplicación. 
AppFactory::setContainer($container);
$app = AppFactory::create();

$container = $app->getContainer();

require __DIR__. '/HandlerError.php';
require __DIR__. '/Services.php';

$middleware = require __DIR__. '/Middleware.php';
$middleware($app);

$routes = require __DIR__. '/Routes.php';
$routes($app);
