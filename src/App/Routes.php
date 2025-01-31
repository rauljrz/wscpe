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
        $app->post('/autorizarCPEAutomotor', autorizarCPEAutomotorController::class);
        $app->post('/autorizarCPEAutomotorDG', autorizarCPEAutomotorDGController::class);

        $app->get('/consultarProvincias', provinciaController::class);
        $app->get('/consultarLocalidadesPorProvincia/{id:[0-9]+}', localidadController::class);
        $app->get('/consultarTiposGrano', tipoGranoController::class);
        $app->get('/consultarUltNroOrden', ultNroOrdenController::class);
        $app->get('/consultarCPEAutomotor', consultarCPEAutomotorController::class);
        $app->get('/consultarCPEAutomotorDG', consultarCPEAutomotorDGController::class);
        $app->get('/CPEAutomotorPDF', CPEAutomotorPDFController::class);
        $app->get('/confirmarArriboCPE', confirmarArriboCPEController::class);
        
        #-- Ruta para que funcione las empresas con codigo anterior al 2024.11.20
        $app->get('/confirmacionDefinitiva', confirmacionDefinitivaCPEAutomotorController::class);
        
        #-- Apartir del 2024.11.20 por SuperDiet
        $app->get('/confirmacionDefinitivaCPEAutomotor'  , confirmacionDefinitivaCPEAutomotorController::class);
        $app->get('/confirmacionDefinitivaCPEAutomotorDG', confirmacionDefinitivaCPEAutomotorDGController::class);
        
        $app->get('/cgBuscarCtg', cgBuscarCtgController::class);

        $app->group('/lpg', function ($app) {
            $app->get('/cgBuscarCtg', cgBuscarCtgController::class);
            $app->post('/cgAutorizar', cgAutorizarController::class);
            $app->get('/cgConsultarUltimoNroOrden', cgConsultarUltimoNroOrdenController::class);
            $app->get('/cgConsultarXCoe', cgConsultarXCoeController::class);
        });
    
        $app->group('/wsfe', function ($app) {
            $app->get('/FECAEAConsultar', FECAEAConsultarController::class);
            $app->post('/FECAESolicitar', FECAESolicitarController::class);
            $app->get('/FECompConsultar', FECompConsultarController::class);
            $app->get('/FECompUltimoAutorizado', FECompUltimoAutorizadoController::class);
            $app->get('/FEDummy', FEDummyController::class);
            $app->get('/FEParamGetActividades', FEParamGetActividadesController::class);
            $app->get('/FEParamGetCotizacion', FEParamGetCotizacionController::class);
            $app->get('/FEParamGetPtosVenta', FEParamGetPtosVentaController::class);
            $app->get('/FEParamGetTiposCbte', FEParamGetTiposCbteController::class);
            $app->get('/FEParamGetTiposConcepto', FEParamGetTiposConceptoController::class);
            $app->get('/FEParamGetTiposDoc', FEParamGetTiposDocController::class);
            $app->get('/FEParamGetTiposIva', FEParamGetTiposIvaController::class);
            $app->get('/FEParamGetTiposMonedas', FEParamGetTiposMonedasController::class);
            $app->get('/FEParamGetTiposPaises', FEParamGetTiposPaisesController::class);
            $app->get('/FEParamGetTiposTributos', FEParamGetTiposTributosController::class);
        });
    
        $app->group('/bcra', function ($app) {
            $app->get('/Cotizaciones[/{moneda}]', CotizacionesController::class);
        });

    })->add(new \App\Middleware\AfipCertificateMiddleware());
};