<?php

declare(strict_types=1);

namespace App\Controller\lpg;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class cgConsultarUltimoNroOrdenController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $ptoEmision = $request->getQueryParams()['ptoEmision'] ?? null;
 
        $data  = $this->wsLPG($args['cuit'])
                      ->cgConsultarUltimoNroOrden
                      ->run(array(
                          'ptoEmision' => $ptoEmision
                      ));
                      
        return $this->jsonResponse($response, 'success', $data->liqUltNroOrdenReturn, 200); 
    }
}