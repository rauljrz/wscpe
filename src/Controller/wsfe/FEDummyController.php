<?php

declare(strict_types=1);

namespace App\Controller\wsfe;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;


class FEDummyController extends BaseController
{
    private const API_VERSION = '1.01.0';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $this->wsFE($args['cuit'])
                    ->FEDummy
                    ->run();

        if ($data['status'] === 'success') {
            $data['data'] = [
                'Servidor de aplicaciones (AppServer)' => $data['data']->AppServer,
                'Servidor de base de datos (DbServer)' => $data['data']->DbServer, 
                'Servidor de autenticación (AuthServer)' => $data['data']->AuthServer
            ];
        }
        return $this->validateResult($response, $data);
    }
}