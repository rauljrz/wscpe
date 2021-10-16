<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class provinciaController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
       // $cuit = $args['cuit'];
      //  throw new \App\Exception\NotAllow('Cuit: '.$cuit, 502);
        $provincias = array(
            array("codigo"=>20, "provincia"=>"tucuman"),
            array("codigo"=>21, "provincia"=>"mexico")
        );

        return $this->jsonResponse($response, 'success', $provincias, 200); 
    }

}
