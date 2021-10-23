<?php

use Psr\Container\ContainerInterface;
use App\Controller\autorizarCPEAutomotorController;
use App\Controller\consultarCPEAutomotorController;
use App\Controller\provinciaController;
use App\Controller\localidadController;
use App\Controller\tipoGranoController;
use App\Controller\ultNroOrdenController;

$container->set('provinciaController', function (ContainerInterface $container) {
    return new provinciaController($container);
});

$container->set('localidadController', function (ContainerInterface $container) {
    return new localidadController($container);
});

$container->set('tipoGranoController', function (ContainerInterface $container) {
    return new tipoGranoController($container);
});

$container->set('ultNroOrdenController', function (ContainerInterface $container) {
    return new ultNroOrdenController($container);
});

$container->set('autorizarCPEAutomotorController', function (ContainerInterface $container) {
    return new autorizarCPEAutomotorController($container);
});

$container->set('consultarCPEAutomotorController', function (ContainerInterface $container) {
    return new consultarCPEAutomotorController($container);
});
