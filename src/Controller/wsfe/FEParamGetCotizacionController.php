<?php

declare(strict_types=1);

namespace App\Controller\wsfe;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

class FEParamGetCotizacionController extends BaseController
{
    private const API_VERSION = '1.01.0';
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $required_fields = ['monid'];
        $body = $request->getParsedBody();

        $this->validateInput($body, $required_fields);

        $data  = $this->wsFE($args['cuit'])
                      ->FEParamGetCotizacion
                      ->run($body);

        return $this->validateResult($response, $data);
    }
}