<?php
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Psr7\Response;

$errorMiddleware = $app->addErrorMiddleware($_ENV['APP_DEBUG'] === 'true', true, true);

$errorMiddleware->setDefaultErrorHandler(
    function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) use ($container) {
        $logger = $container->get(\Psr\Log\LoggerInterface::class);
        $response = new Response();
        $statusCode = 500;
        $content = 'application/problem+json';
        
        $filename = 'errors_' . date('Ymd');
        $maxAge = strtotime('-2 months');
        
        // Limpiar logs antiguos
        $files = glob('errors_*.log');
        foreach($files as $file) {
            $fileDate = substr(basename($file, '.log'), 7); // Extrae YYYYMMDD
            if(strtotime($fileDate) < $maxAge) {
                unlink($file);
            }
        }
        
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($filename . '.log'));
        $logger->error($exception->getMessage(), [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
            
        $data = [
            'message' => $exception->getMessage(),
            'status' => 'Error',
            'code' => $statusCode
        ];

        if($_ENV['APP_DEBUG'] === 'true' && $displayErrorDetails) {
            $data['details'] = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ];
        }

        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $response->getBody()->write((string) $body);

        return $response->withStatus($statusCode)
                        ->withHeader('Content-type', $content);
    });

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
//$errorHandler->forceContentType('application/json');