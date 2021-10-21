<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class autorizarCPEAutomotorController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {

        $input = $request->getParsedBody();
        
        $data  = $this->wsCPE($args['cuit'])
                      ->autorizarCPEAutomotor
                      ->run($input);

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
