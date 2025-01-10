<?php

declare(strict_types=1);

namespace App\Controller\lpg;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class cgConsultarXCoeController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $coe = $request->getQueryParams()['coe'] ?? null;
 
        $data  = $this->wsLPG($args['cuit'])
                      ->cgConsultarXCoe
                      ->run(['coe' => $coe]);
        
        return $this->validateResult($response, $data);
    }
}