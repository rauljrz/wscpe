<?php
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Psr7\Response;

$errorMiddleware = $app->addErrorMiddleware($_ENV['APP_DEBUG'] === 'true', true, true);

// Set the Not Found Handler
$errorMiddleware->setErrorHandler(
    HttpNotFoundException::class,
    function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) {
        $response = new Response();
        $content = 'application/problem+json';
        $statusCode = 404;
        $data = [
            'message' => 'Route Not Found',
            'status' => 'Error',
            'code' => $statusCode 
        ];
        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $response->getBody()->write((string) $body);
                        
        return $response->withStatus($statusCode)
                        ->withHeader('Content-type', $content);
    });

// Set the Not Allowed Handler
$errorMiddleware->setErrorHandler(
    HttpMethodNotAllowedException::class,
    function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) {
        $response = new Response();
        $content = 'application/problem+json';
        $statusCode = 405;
        $data = [
            'message' => 'Not Allowed',
            'status' => 'Error',
            'code' => $statusCode 
        ];
        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $response->getBody()->write((string) $body);
                        
        return $response->withStatus($statusCode)
                        ->withHeader('Content-type', $content);
    });

$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');
