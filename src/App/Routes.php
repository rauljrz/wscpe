<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello World");
        return $response;
    });

    $app->get('/user/{name}', function (Request $request, Response $response, $args)
    {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->group('/api/v1/{cuit:[1-9][0-9]{10}}', function ($app) {
        $app->get('/consultarProvincias', \provinciaController::class);
        $app->get('/consultarLocalidades/{id:[0-9]+}', \localidadController::class);
    });
};
// /[1-9][0-9]{10}/g
