<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class confirmacionDefinitivaCPEAutomotorDGController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $cuitSolicitante= $request->getQueryParams()['cuitSolicitante'] ?? $args['cuit'];
        $sucursal = $request->getQueryParams()['sucursal'] ?? null;
        $nroOrden = $request->getQueryParams()['nroOrden'] ?? null;
        $tipoCPE  = $request->getQueryParams()['tipoCPE' ] ?? 74;
        $pesoBrutoDescarga = $request->getQueryParams()['pesoBrutoDescarga'] ?? null;
        $pesoTaraDescarga  = $request->getQueryParams()['pesoTaraDescarga' ] ?? null;

        $data  = $this->wsCPE($args['cuit'])
                      ->confirmacionDefinitivaCPEAutomotorDG
                      ->run(array(
                          'cuitSolicitante'=> $cuitSolicitante,
                          'sucursal' => $sucursal,
                          'nroOrden' => $nroOrden,
                          'tipoCPE'  => $tipoCPE ,
                          'pesoBrutoDescarga' => $pesoBrutoDescarga,
                          'pesoTaraDescarga'  => $pesoTaraDescarga )
                      );

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
