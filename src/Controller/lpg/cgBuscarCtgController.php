<?php

declare(strict_types=1);

namespace App\Controller\lpg;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class cgBuscarCtgController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $tipoCertificado = $request->getQueryParams()['tipoCertificado'] ?? null;
        $cuitDepositante = $request->getQueryParams()['cuitDepositante'] ?? null;
        $nroPlanta       = $request->getQueryParams()['nroPlanta'] ?? null;
        $codGrano        = $request->getQueryParams()['codGrano'] ?? null;
        $campania        = $request->getQueryParams()['campania'] ?? null;
 
        $data  = $this->wsLPG($args['cuit'])
                      ->cgBuscarCtg
                      ->run(array(
                          'tipoCertificado' => $tipoCertificado,
                          'cuitDepositante' => $cuitDepositante,
                          'nroPlanta'       => $nroPlanta,
                          'codGrano'        => $codGrano,
                          'campania'        => $campania)
                      );

        return $this->jsonResponse($response, 'success', $data, 200); 
    }
}