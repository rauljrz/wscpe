<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AfipCertificateMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $params = $request->getServerParams();
        $request_uri = $params['REQUEST_URI'];
        $uri_array = explode('/', $request_uri);
        $cuit = $uri_array[3];

        $baseDir = __DIR__ . '/../../'.$_ENV['DIR_Certf'] ?? '';
        
        $certFile = $baseDir . $cuit . '_cert';
        $keyFile = $baseDir . $cuit . '_key';
        
        $errors = [];
        if (!file_exists($certFile))
            $errors[] = "No se encuentra el archivo de certificado para el CUIT $cuit";
        
        if (!file_exists($keyFile))
            $errors[] = "No se encuentra el archivo de clave privada para el CUIT $cuit";
        
        if (!empty($errors)) {
            $response = new \Slim\Psr7\Response();
            $data = [
                'code' => 400,
                'status' => 'Error',
                'messages' => ['error' => $errors]
            ];
            $response->getBody()
                     ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/problem+json');
        }
        
        return $handler->handle($request);
    }
}