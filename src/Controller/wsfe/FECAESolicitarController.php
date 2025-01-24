<?php

declare(strict_types=1);

namespace App\Controller\wsfe;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;


class FECAESolicitarController extends BaseController
{
    private const API_VERSION = '1.01.0';
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $body = $request->getBody()->getContents();
        $input = json_decode($body, true);

        if (!is_array($input) || empty($input))
            return $this->jsonResponse(
                $response,
                'error', 
                'Los datos de entrada son inválidos o están vacíos',
                422
            );
        
        // Campos requeridos
        $required_fields = [
            'CbteTipo', 'PtoVta', 'Concepto', 'DocTipo', 'DocNro',
            'CbteDesde', 'CbteHasta', 'CbteFch', 'ImpTotal', 'ImpTotConc',
            'ImpNeto', 'ImpOpEx', 'ImpTrib', 'ImpIVA', 'FchServDesde',
            'FchServHasta', 'FchVtoPago', 'MonId', 'MonCotiz'
        ];
        
        // Validar campos requeridos
        $this->validateInput($input, $required_fields);

        $data  = $this->wsFE($args['cuit'])
                      ->FECAESolicitar
                      ->run($input);

        return $this->validateResult($response, $data);
    }
}