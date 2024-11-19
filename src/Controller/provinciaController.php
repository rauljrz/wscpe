<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class provinciaController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
       // $cuit = $args['cuit'];
      //  throw new \App\Exception\NotAllow('Cuit: '.$cuit, 502);

        $data  = $this->wsCPE($args['cuit'])
                      ->consultarProvincias->run();

        return $this->jsonResponse($response, 'success', $data, 200); 
    }

}
