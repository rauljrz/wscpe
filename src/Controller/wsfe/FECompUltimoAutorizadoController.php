<?php

declare(strict_types=1);

namespace App\Controller\wsfe;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;


class FECompUltimoAutorizadoController extends BaseController
{
    private const API_VERSION = '1.01.0';
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $body = $request->getBody()->getContents();
        $input = json_decode($body, true);

        if (!isset($input['PtoVta']) || !is_int($input['PtoVta']) ||
            !isset($input['CbteTipo']) || !is_int($input['CbteTipo'])) {
            return $this->jsonResponse(
                $response,
                'error',
                'Se requiere PtoVta y CbteTipo como números enteros',
                422
            );
        }

        $data = $this->wsFE($args['cuit'])
                    ->FECompUltimoAutorizado
                    ->run($input);

        return $this->validateResult($response, $data);
    }
}