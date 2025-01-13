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
        
        if (isset($data['status']) && $data['status'] === 'error')
            return $this->jsonResponse($response, 'error', $data['message'], $data['code'] ?? 500);

        $message = array(
            'ptoEmision'      => $data['data']->autorizacion->ptoEmision,
            'nroOrden'        => $data['data']->autorizacion->nroOrden,
            'coe'             => $coe,
            'estado'          => $data['data']->autorizacion->estado,
            'pdf'             => base64_encode($data['data']->pdf),
        );
        return $this->jsonResponse($response, 'success', $message, 200);
    }
}