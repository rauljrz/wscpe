<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class consultarCPEAutomotorController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $cuitSolicitante= $request->getQueryParams()['cuitSolicitante'] ?? null;
        $nroCTG = $request->getQueryParams()['nroCTG'] ?? null;

        $data  = $this->wsCPE($args['cuit'])
                      ->consultarCPEAutomotor
                      ->run(array(
                          'cuitSolicitante'=> $cuitSolicitante,
                          'nroCTG' => $nroCTG)
                      );

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
