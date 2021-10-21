<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class ultNroOrdenController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $sucursal= $request->getQueryParams()['sucursal'] ?? null;
        $tipoCPE = $request->getQueryParams()['tipoCPE'] ?? null;

        $data  = $this->wsCPE($args['cuit'])
                      ->consultarUltNroOrden
                      ->run(array(
                          'sucursal'=> $sucursal,
                          'tipoCPE' => $tipoCPE)
                      );

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
