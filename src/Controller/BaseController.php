<?php

declare(strict_types=1);

namespace App\Controller;

use App\Afip\wsAfip;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface AS Response;
use Psr\Http\Message\ServerRequestInterface AS Request;
use Respect\Validation\Rules\Uppercase;

abstract class BaseController
{
    private $container;
    private $folder_Logger;
    private $folder_Certf;
    private $folder_Token;
    private $production;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $baseDir = $this->container->get('settings')['baseDir'];

        $this->production = (strtoupper($_SERVER['PRODUCTION'])==='TRUE');
        $this->folder_Certf = $baseDir . $_SERVER['DIR_Certf'];
        $this->folder_Logger= $this->container->get('settings')['logger']['path'];
        $this->folder_Token = $baseDir . $_SERVER['DIR_Token']; 
    }

    /**
     * @param int $cuit
     */
    protected function wsCPE($cuit) {
        $wsAfip = new wsAfip(array(
			'CUIT'      => $cuit,
			'production'=> $this->production,
			'res_folder'=> $this->folder_Certf,
			'ta_folder' => $this->folder_Token,
            'app_debug' => $_ENV['APP_DEBUG'],
            'log_folder'=> $this->folder_Logger)
        );
        return $wsAfip->wsCPE;
    }

    /**
     * @param int $cuit
     */
    protected function wsLPG($cuit) {
        $wsAfip = new wsAfip(array(
			'CUIT'      => $cuit,
			'production'=> $this->production,
			'res_folder'=> $this->folder_Certf,
			'ta_folder' => $this->folder_Token,
            'app_debug' => $_ENV['APP_DEBUG'],
            'log_folder'=> $this->folder_Logger)
        );
        return $wsAfip->wsLPG;
    }
        /**
     * @param int $cuit
     */
    protected function wsFE($cuit) {
        $wsAfip = new wsAfip(array(
			'CUIT'      => $cuit,
			'production'=> $this->production,
			'res_folder'=> $this->folder_Certf,
			'ta_folder' => $this->folder_Token,
            'app_debug' => $_ENV['APP_DEBUG'],
            'log_folder'=> $this->folder_Logger)
        );
        return $wsAfip->wsFE;
    }

    protected function validateInput(array $input, array $required_fields)
    {
        $missing_fields = [];
        foreach ($required_fields as $field) {
            $found = false;
            
            // Verificar primer nivel
            if (isset($input[$field])) {
                dd('se encontro ' . $field);
                $found = true;
            } else {
                // Verificar segundo nivel
                foreach ($input as $key => $value) {
                    if (is_array($value) && isset($value[$field])) {
                        $found = true;
                        break;
                    }
                }
            }
            
            if (!$found) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields))
            throw new \Exception('Campos requeridos faltantes: ' . implode(', ', $missing_fields));
    }
    protected function validateResult(Response $response, array $data)
    {
        if (isset($data['status']) && $data['status'] === 'error')
            return $this->jsonResponse($response, 'error', $data['message'], 422);

        return $this->jsonResponse($response,
                        'success',
                        $data['data'],
                        200); 
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

        $messageJson = json_encode($result, JSON_PRETTY_PRINT);
        $response->getBody()
                 ->write($messageJson); 

        return $response->withStatus($code)
                        ->withHeader('Content-type', 'application/json');
    }

    protected function Utf8_ansi($valor='') {
        $utf8_ansi2 = array(
            "\u00c0" =>"À",
            "\u00c1" =>"Á",
            "\u00c2" =>"Â",
            "\u00c3" =>"Ã",
            "\u00c4" =>"Ä",
            "\u00c5" =>"Å",
            "\u00c6" =>"Æ",
            "\u00c7" =>"Ç",
            "\u00c8" =>"È",
            "\u00c9" =>"É",
            "\u00ca" =>"Ê",
            "\u00cb" =>"Ë",
            "\u00cc" =>"Ì",
            "\u00cd" =>"Í",
            "\u00ce" =>"Î",
            "\u00cf" =>"Ï",
            "\u00d1" =>"Ñ",
            "\u00d2" =>"Ò",
            "\u00d3" =>"Ó",
            "\u00d4" =>"Ô",
            "\u00d5" =>"Õ",
            "\u00d6" =>"Ö",
            "\u00d8" =>"Ø",
            "\u00d9" =>"Ù",
            "\u00da" =>"Ú",
            "\u00db" =>"Û",
            "\u00dc" =>"Ü",
            "\u00dd" =>"Ý",
            "\u00df" =>"ß",
            "\u00e0" =>"à",
            "\u00e1" =>"á",
            "\u00e2" =>"â",
            "\u00e3" =>"ã",
            "\u00e4" =>"ä",
            "\u00e5" =>"å",
            "\u00e6" =>"æ",
            "\u00e7" =>"ç",
            "\u00e8" =>"è",
            "\u00e9" =>"é",
            "\u00ea" =>"ê",
            "\u00eb" =>"ë",
            "\u00ec" =>"ì",
            "\u00ed" =>"í",
            "\u00ee" =>"î",
            "\u00ef" =>"ï",
            "\u00f0" =>"ð",
            "\u00f1" =>"ñ",
            "\u00f2" =>"ò",
            "\u00f3" =>"ó",
            "\u00f4" =>"ô",
            "\u00f5" =>"õ",
            "\u00f6" =>"ö",
            "\u00f8" =>"ø",
            "\u00f9" =>"ù",
            "\u00fa" =>"ú",
            "\u00fb" =>"û",
            "\u00fc" =>"ü",
            "\u00fd" =>"ý",
            "\u00ff" =>"ÿ");

        return strtr($valor, $utf8_ansi2);      

    }
    protected static function isRedisEnabled(): bool
    {
        return filter_var($_SERVER['REDIS_ENABLED'], FILTER_VALIDATE_BOOLEAN);
    }
}
