<?php

use Psr\Container\ContainerInterface;
use App\Controller\provinciaController;
use App\Controller\localidadController;

$container->set('provinciaController', function (ContainerInterface $container) {
    return new provinciaController($container);
});

$container->set('localidadController', function (ContainerInterface $container) {
    return new localidadController($container);
});
