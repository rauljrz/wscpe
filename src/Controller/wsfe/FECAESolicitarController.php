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
        $required_fields = [
            'cbtetipo', 'ptovta', 'concepto', 'doctipo', 'docnro',
            'cbtedesde', 'cbtehasta', 'cbtefch', 'imptotal', 'imptotconc',
            'impneto', 'impopex', 'imptrib', 'impiva', 'fchservdesde',
            'fchservhasta', 'fchvtopago', 'monid', 'moncotiz'
        ];

        $body = $request->getBody()->getContents();
        $input = json_decode($body, true);
        
        // Validar campos requeridos
        $this->validateInput($input, $required_fields);

        $data  = $this->wsFE($args['cuit'])
                      ->FECAESolicitar
                      ->run($input);

        return $this->validateResult($response, $data);
    }
}