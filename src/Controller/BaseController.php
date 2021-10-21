<?php

declare(strict_types=1);

namespace App\Controller;

use App\Afip\wsAfip;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;

abstract class BaseController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param int $cuit
     */
    protected function wsCPE($cuit) {
        // $cuit = $args['cuit'];
        $baseDir = __DIR__ . '/../..';

        $folder_Token = $baseDir . $_SERVER['DIR_Token'];
        $folder_Certf = $baseDir . $_SERVER['DIR_Certf'];
        $folder_Logger= $baseDir . $_SERVER['DIR_Log'];

        $production = $_SERVER['PRODUCTION'];

        $wsAfip = new wsAfip(array(
			'CUIT'      => $cuit,
			'production'=> $production,
			'res_folder'=> $folder_Certf,
			'ta_folder' => $folder_Token,
            'app_debug' => $_ENV['APP_DEBUG'],
            'log_folder'=> $folder_Logger)
        );
        return $wsAfip->wsCPE;
    }

    /**
     * @param array|object|null $message
     */
    protected function jsonResponse(
        Response $response,
        string $status,
        $message,
        int $code
    ): Response {

        $result = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
        ];

        $response->getBody()
                 ->write((string) json_encode($result, JSON_PRETTY_PRINT));

        return $response->withStatus($code)
                        ->withHeader('Content-type', 'application/json');
    }

    protected static function isRedisEnabled(): bool
    {
        return filter_var($_SERVER['REDIS_ENABLED'], FILTER_VALIDATE_BOOLEAN);
    }
}
