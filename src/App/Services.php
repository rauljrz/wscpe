<?php

use Psr\Container\ContainerInterface;
use App\Controller\autorizarCPEAutomotorController;
use App\Controller\autorizarCPEAutomotorDGController;
use App\Controller\confirmacionDefinitivaCPEAutomotorController;
use App\Controller\confirmacionDefinitivaCPEAutomotorDGController;
use App\Controller\confirmarArriboCPEController;
use App\Controller\consultarCPEAutomotorController;
use App\Controller\consultarCPEAutomotorDGController;
use App\Controller\CPEAutomotorPDFController;
use App\Controller\provinciaController;
use App\Controller\localidadController;
use App\Controller\tipoGranoController;
use App\Controller\ultNroOrdenController;
use App\Controller\lpg\cgBuscarCtgController;
use App\Controller\lpg\cgAutorizarController;
use App\Controller\lpg\cgConsultarUltimoNroOrdenController;
use App\Controller\lpg\cgConsultarXCoeController;

//* Factura Electronica - *//
use App\Controller\wsfe\FECAEAConsultarController;
use App\Controller\wsfe\FECAESolicitarController;
use App\Controller\wsfe\FECompConsultarController;
use App\Controller\wsfe\FECompUltimoAutorizadoController;
use App\Controller\wsfe\FEDummyController;
use App\Controller\wsfe\FEParamGetActividadesController;
use App\Controller\wsfe\FEParamGetCondicionIvaReceptorController;
use App\Controller\wsfe\FEParamGetCotizacionController;
use App\Controller\wsfe\FEParamGetPtosVentaController;
use App\Controller\wsfe\FEParamGetTiposCbteController;
use App\Controller\wsfe\FEParamGetTiposConceptoController;
use App\Controller\wsfe\FEParamGetTiposDocController;
use App\Controller\wsfe\FEParamGetTiposIvaController;
use App\Controller\wsfe\FEParamGetTiposMonedasController;
use App\Controller\wsfe\FEParamGetTiposPaisesController;
use App\Controller\wsfe\FEParamGetTiposTributosController;

//* BCR - Cotizaciones *//
use App\Controller\bcra\CotizacionesController;

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
$container->set('cgAutorizarController', function (ContainerInterface $container) {
    return new cgAutorizarController($container);
});
$container->set('cgConsultarUltimoNroOrdenController', function (ContainerInterface $container) {
    return new cgConsultarUltimoNroOrdenController($container);
});
$container->set('cgConsultarXCoeController', function (ContainerInterface $container) {
    return new cgConsultarXCoeController($container);
});

/* Factura Electronica */
$container->set('FECAEAConsultarController', function (ContainerInterface $container) {
    return new FECAEAConsultarController($container);
});
$container->set('FECAESolicitarController', function (ContainerInterface $container) {
    return new FECAESolicitarController($container);
});
$container->set('FECompConsultarController', function (ContainerInterface $container) {
    return new FECompConsultarController($container);
});
$container->set('FECompUltimoAutorizadoController', function (ContainerInterface $container) {
    return new FECompUltimoAutorizadoController($container);
});
$container->set('FEDummyController', function (ContainerInterface $container) {
    return new FEDummyController($container);
});
$container->set('FEParamGetActividadesController', function (ContainerInterface $container) {
    return new FEParamGetActividadesController($container);
});
$container->set('FEParamGetCondicionIvaReceptorController', function (ContainerInterface $container) {
    return new FEParamGetCondicionIvaReceptorController($container);
});
$container->set('FEParamGetCotizacionController', function (ContainerInterface $container) {
    return new FEParamGetCotizacionController($container);
});
$container->set('FEParamGetPtosVentaController', function (ContainerInterface $container) {
    return new FEParamGetPtosVentaController($container);
});
$container->set('FEParamGetTiposCbteController', function (ContainerInterface $container) {
    return new FEParamGetTiposCbteController($container);
});
$container->set('FEParamGetTiposConceptoController', function (ContainerInterface $container) {
    return new FEParamGetTiposConceptoController($container);
});
$container->set('FEParamGetTiposDocController', function (ContainerInterface $container) {
    return new FEParamGetTiposDocController($container);
});
$container->set('FEParamGetTiposIvaController', function (ContainerInterface $container) {
    return new FEParamGetTiposIvaController($container);
});
$container->set('FEParamGetTiposMonedasController', function (ContainerInterface $container) {
    return new FEParamGetTiposMonedasController($container);
});
$container->set('FEParamGetTiposPaisesController', function (ContainerInterface $container) {
    return new FEParamGetTiposPaisesController($container);
});
$container->set('FEParamGetTiposTributosController', function (ContainerInterface $container) {
    return new FEParamGetTiposTributosController($container);
});
/* BCR - Cotizaciones */
$container->set('CotizacionesController', function (ContainerInterface $container) {
    return new CotizacionesController($container);
});