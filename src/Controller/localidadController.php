<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class localidadController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data  = $this->wsCPE($args['cuit'])
                      ->consultarLocalidadesPorProvincia
                      ->run($args['id']);

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
