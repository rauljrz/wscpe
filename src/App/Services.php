<?php

use Psr\Container\ContainerInterface;
use App\Controller\autorizarCPEAutomotorController;
use App\Controller\autorizarCPEAutomotorDGController;
use App\Controller\confirmacionDefinitivaCPEAutomotorController;
use App\Controller\confirmacionDefinitivaCPEAutomotorControllerDG;
use App\Controller\confirmarArriboCPEController;
use App\Controller\consultarCPEAutomotorController;
use App\Controller\consultarCPEAutomotorDGController;
use App\Controller\CPEAutomotorPDFController;
use App\Controller\provinciaController;
use App\Controller\localidadController;
use App\Controller\tipoGranoController;
use App\Controller\ultNroOrdenController;
use App\Controller\cgBuscarCtgController;

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

$container->set('autorizarCPEAutomotorDGController', function (ContainerInterface $container) {
    return new autorizarCPEAutomotorDGController($container);
});
$container->set('autorizarCPEAutomotorController', function (ContainerInterface $container) {
    return new autorizarCPEAutomotorController($container);
});

$container->set('consultarCPEAutomotorController', function (ContainerInterface $container) {
    return new consultarCPEAutomotorController($container);
});

$container->set('consultarCPEAutomotorDGController', function (ContainerInterface $container) {
    return new consultarCPEAutomotorDGController($container);
});


$container->set('CPEAutomotorPDFController', function (ContainerInterface $container) {
    return new CPEAutomotorPDFController($container);
});

$container->set('confirmarArriboCPEController', function (ContainerInterface $container) {
    return new confirmarArriboCPEController($container);
});

$container->set('confirmacionDefinitivaCPEAutomotorController', function (ContainerInterface $container) {
    return new confirmacionDefinitivaCPEAutomotorController($container);
});

$container->set('confirmacionDefinitivaCPEAutomotorDGController', function (ContainerInterface $container) {
    return new confirmacionDefinitivaCPEAutomotorDGController($container);
});

$container->set('cgBuscarCtgController', function (ContainerInterface $container) {
    return new cgBuscarCtgController($container);
});