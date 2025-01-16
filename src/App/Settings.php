<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function (Container $container) {
    $container->set('settings', function() {
        $baseDir = __DIR__ . '/../../' ;
        return [
            'name' => 'API Restful WSCPElectronica - AFIP',
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
            'baseDir'   => $baseDir,
            'logger' => [
                'name'  => 'Errors',
                'path'  => $baseDir.'/logs/',
                'file'  => 'errors_'.date('Ymd').'.log',
                'level' => Logger::DEBUG,
            ],
            'connection' => [
                'host'   => 'api_wscpe',
                'dbname' => 'db',
                'dbuser' => 'user',
                'dbpass' => 'secret',
            ]
        ];
    });
};
